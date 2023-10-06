@extends('layouts.app')

@section('content')

<x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
                </h2>
                <div x-data="{ isOpen: false }">
                    <button @click="isOpen = true" class="text-white font-bold py-2 px-4 rounded" style="background-color: #008000;">
                        Create Task
                </button>
    <template x-if="isOpen">
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="modal-backdrop fixed inset-0 bg-black opacity-30" @click="isOpen = false"></div>
            <div class="modal-content bg-white p-6 rounded shadow-lg" style="width: 400px; position: relative; z-index: 10;">
                <h2 class="text-xl font-bold mb-4 text-center">Create Task</h2>
                <form>
                    <div class="mb-4">
                        <label for="taskName" class="block text-gray-700 text-sm font-bold mb-2">Task Name:</label>
                        <input wire:model="name" type="text" class="form-input rounded w-full" id="taskName" required placeholder="Enter task name">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                        <textarea wire:model="description" class="form-textarea rounded w-full" id="description" placeholder="Enter task description"></textarea>
                    </div>
                    <div>
                        <label for="category">Select a category:</label>
                        <select wire:model="category" id="category" class="form-control">
                            <option value="">Select...</option>
                            <option value="Work">Work</option>
                            <option value="Personal">Personal</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="dueDate" class="block text-gray-700 text-sm font-bold mb-2">Due Date:</label>
                        <input wire:model="due_date" type="date" class="form-input rounded w-full" id="dueDate">
                    </div>
                    <div class="mb-4">
                        <label for="priorityLevel" class="block text-gray-700 text-sm font-bold mb-2">Priority Level:</label>
                        <input wire:model="priority_level" type="number" class="form-control" id="priorityLevel" min="1">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="btn btn-secondary mr-2" @click="isOpen = false">Cancel</button>
                        <button  wire:click.prevent="store()" type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
</x-slot>

<div class="flex justify-center h-screen bg-white">
    <div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Due Date</th>
                        <th>Priority Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->category }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>{{ $task->priority_level }}</td>
                            <td>
                                <button class="btn btn-primary" wire:click="edit({{ $task->id }})">Edit</button>
                                <button class="btn btn-danger" wire:click="delete({{ $task->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .table th {
        padding-left: 4rem;
        padding-right: 4rem;
    }
</style>
@endsection
