<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;

use Livewire\Component;
use App\Models\Task;

class Tasks extends Component
{
    use WithPagination;

    public $name, $description, $category, $due_date, $priority_level, $task_id;
    public $isOpen = 0;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $search = '';

    public function render()
    {
        $tasks = Task::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('category', 'like', '%' . $this->search . '%')
            ->orWhere('due_date', 'like', '%' . $this->search . '%')
            ->orWhere('priority_level', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.tasks', compact('tasks'));
    }


    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'nullable',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority_level' => 'nullable|integer|min:1',
        ]);
        Task::updateOrCreate(['id' => $this->task_id], [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'due_date' => $this->due_date,
            'priority_level' => $this->priority_level,
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
        $this->category = $task->descripcategorytion;
        $this->due_date = $task->due_date;
        $this->priority_level = $task->priority_level;
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
   
}
