<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tasks as TaskModel;
use Illuminate\Support\Facades\Log;

class Task extends Component
{
    public $name, $description, $category, $due_date, $priority_level;
    public $updateMode = false;
    public $tasks;

    public function render()
    {
        $this->tasks = TaskModel::all();
        return view('livewire.task');
    }   

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'nullable',
            'due_date' => 'nullable|date',
            'priority_level' => 'nullable|integer|min:1',
        ]);

        TaskModel::create(['name' => $this->name],
                        ['description'=> $this->description],
                        ['category' => $this->category],
                        ['due_date' => $this->due_date],
                        ['priority_level' => $this->priorty_level]);

        Log::info('pasokg');
        session()->flash('message', 'Task Created Successfully.');
        $this->resetInputFields();
        $this->updateMode = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->category = '';
        $this->due_date = '';
        $this->priority_level = '';
    }

    public function edit($id)
    {
        $task = TaskModel::findOrFail($id);
        $this->name = $task->name;
        $this->description = $task->description;
        $this->category = $task->category;
        $this->due_date = $task->due_date;
        $this->priority_level = $task->priority_level;
        $this->updateMode = true;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'nullable',
            'due_date' => 'nullable|date',
            'priority_level' => 'nullable|integer',
        ]);

        TaskModel::where('id', $this->task_id)->update($validatedData);

        $this->updateMode = false;
        session()->flash('message', 'Task Updated Successfully.');
        $this->resetInputFields();
    }

    public function delete($id)
    {
        TaskModel::find($id)->delete();
        session()->flash('message', 'Task Deleted Successfully.');
    }
}
