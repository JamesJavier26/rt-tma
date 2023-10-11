<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <div>
                    <input wire:model="search" type="text" class="border border-gray-300 rounded py-2 px-4" placeholder="Search...">
                </div>
                <div>
                    <button wire:click="create()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Create New Task
                    </button>
                </div>
            </div>

            @if($isOpen)
                @include('livewire.create')
            @endif

            <table class="table-fixed w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('name')">Name</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('description')">Description</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('category')">Category</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('due_date')">Due Date</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('priority_level')">Priority Level</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr class="bg-white">
                            <td class="px-4 py-2 border">{{ $task->name }}</td>
                            <td class="px-4 py-2 border">{{ $task->description }}</td>
                            <td class="px-4 py-2 border">{{ $task->category }}</td>
                            <td class="px-4 py-2 border">{{ $task->due_date }}</td>
                            <td class="px-4 py-2 border">{{ $task->priority_level }}</td>
                            <td class="px-4 py-2 border">
                                <button wire:click="edit({{ $task->id }})" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $task->id }})" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
