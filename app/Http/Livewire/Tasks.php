<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Notifications\TaskCommentNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class Tasks extends Component
{
    use WithPagination;

    public $name, $description, $category, $due_date, $priority_level, $task_id;
    public $isOpen = 0;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $search = '';
    public $users;
    public $task;
    public $comments;   
    public $isViewOpen = false;
    public $isCompleted = false;
    public $commentContent = '';
    public $notifications;
    public $showNotifications = false;
    public $unreadNotificationsCount;
    protected $completedTasks;

    
    public function mount()
    {
        $this->users = User::pluck('name', 'id');

        $this->unreadNotificationsCount = auth()->user()->unreadNotifications->count();
    }

    public function render()
    {
        if ($this->isCompleted) {
            $completedTasks = Task::with('user')
                ->whereNotNull('completed_at')
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(10);

            return view('livewire.completed', ['completedTasks' => $completedTasks]);
        } else {
            $tasks = Task::with('user')
                ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
                ->select('tasks.*', 'users.name as assignee_name')
                ->where(function($query) {
                    $query->where('tasks.name', 'like', '%' . $this->search . '%')
                          ->orWhere('tasks.description', 'like', '%' . $this->search . '%')
                          ->orWhere('tasks.category', 'like', '%' . $this->search . '%')
                          ->orWhere('tasks.due_date', 'like', '%' . $this->search . '%')
                          ->orWhere('tasks.priority_level', 'like', '%' . $this->search . '%');
                })
                ->whereNull('completed_at')
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(10);

            return view('livewire.tasks', compact('tasks'));
        }
    }


    public function sortByAssignee()
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->sortBy = 'assignee_name'; // Use the alias we defined in the query
    }


    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'nullable',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority_level' => 'nullable|integer|min:1',
            'assignee' => 'nullable|exists:users,id',
        ]);
        Task::updateOrCreate(['id' => $this->task_id], [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'due_date' => $this->due_date,
            'priority_level' => $this->priority_level,
            'user_id' => $this->assignee,
        ]);
        session()->flash('message', $this->task_id ? 'Task Updated Successfully.' : 'Task Created Successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('message', 'Task Deleted Successfully.');
    }
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->task_id = $id;
        $this->name = $task->name;
        $this->description = $task->description;
        $this->category = $task->category;
        $this->due_date = $task->due_date;
        $this->priority_level = $task->priority_level;
        $this->assignee = $task->user_id;
        $this->openModal();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false; 
    }
    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->category = '';
        $this->due_date = '';
        $this->priority_level = '';
        $this->assignee = null;
    }

    public function sortBy($field)
    {
        if ($field !== $this->sortBy) {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }

        $this->sortBy = $field;
    }
    public function resetPage()
    {
        $this->resetPage();
    }

    public function completeTask($taskId)
    {
        $task = Task::find($taskId);
        $task->completed_at = now();
        $task->save();
        $this->isViewOpen = false;
        session()->flash('message', 'Task Completed.');
    }

    public function openCompleted()
    {
        $this->isCompleted = true;
    }
    
    public function closeCompleted()
    {
        $this->isCompleted = false;
        $this->completedTasks = null;
    }

    public function openView($taskId)
    {
        Auth::user()->unreadNotifications
        ->where('data.task_id', $taskId)
        ->markAsRead();
        
        $this->task = Task::findOrFail($taskId);
        $this->comments = Comment::where('task_id', $taskId)->with('user')->get();
        $this->isViewOpen = true;
        $this->closeNotifications();
    }

    public function closeView()
    {
        $this->isViewOpen = false;
    }

    public function addComment($taskId)
    {
        $task = Task::with('user')->find($taskId);
    
        // Check if the comment author is not the task assignee
        if (auth()->id() !== $task->user->id) {
            $comment = Comment::create([
                'task_id' => $taskId,
                'comment' => $this->commentContent,
                'user_id' => auth()->id(),
            ]);
    
            // Notify the task assignee
            Notification::send($task->user, new TaskCommentNotification($task, $comment));
        }
    
        $this->commentContent = '';
        session()->flash('message', 'Comment added successfully.');
    }
    

    
    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);

        if ($comment) {
            $comment->delete();
            session()->flash('message', 'Comment deleted successfully.');
        }
    }

    public function refreshComments()
    {
        $this->comments = Comment::where('task_id', $this->task->id)->with('user')->get();
    }

    public function openNotifications()
    {
        $this->showNotifications = true;
    }

    public function closeNotifications()
    {
        $this->showNotifications = false;
    }

    public function refreshNotifications()
    {
        $this->unreadNotificationsCount = Auth::user()->unreadNotifications()->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->where('id', $notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
            $this->refreshNotifications(); // Add this line to force Livewire refresh
        }
    }
}
