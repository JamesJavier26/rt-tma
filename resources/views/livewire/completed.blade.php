<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2>
</x-slot>

<div class="py-12" wire:poll>
    <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
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
            <table class="table-fixed w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('name')">Name</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('description')">Description</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('category')">Category</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('due_date')">Due Date</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortBy('priority_level')">Priority Level</th>
                        <th class="px-4 py-2 border cursor-pointer" wire:click="sortByAssignee">Assignee</th>
                        <th class="px-4 py-2 border">Completed At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedTasks as $task)
                        <tr class="bg-white">
                            <td class="px-4 py-2 border">{{ $task->name }}</td>
                            <td class="px-4 py-2 border">{{ $task->description }}</td>
                            <td class="px-4 py-2 border">{{ $task->category }}</td>
                            <td class="px-4 py-2 border">{{ $task->due_date }}</td>
                            <td class="px-4 py-2 border">{{ $task->priority_level }}</td>
                            <td class="px-4 py-2 border">
                                @if($task->user)
                                    {{ $task->user->name }}
                                @else
                                    Not Assigned
                                @endif
                            </td>
                            <td class="px-4 py-2 border">{{ $task->completed_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-start mb-4 mt-4">
                <button wire:click="closeCompleted" class="inline-flex items-center px-3 py-2 ml-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:shadow-outline-green disabled:opacity-25 transition ease-in-out duration-150" style="background-color: #38A169;">
                    Show Pending Tasks
                </button>
            </div>
        </div>
    </div>
</div>
