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

            <div class="flex justify-between mb-4">
            <div class="flex items-center">
                <input wire:model="search" type="text" class="border border-gray-300 rounded py-2 px-4" placeholder="Search...">
            </div>
    
            <div class="flex items-center space-x-4" wire:poll="refreshNotifications">
                <button wire:click="openNotifications" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 448 512">
                        <path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/>
                    </svg>
                    @if($unreadNotificationsCount > 0)
                        <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-1 py-0.5 text-xs" style="font-size: 0.6rem;">{{ $unreadNotificationsCount }}</span>
                    @endif
                </button>

                <button wire:click="create" class="inline-flex items-center px-4 py-2 ml-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                    Create New Task
                </button>
            </div>
        </div>

            @if($isOpen)
                @include('livewire.create')
            @endif
            @if($isViewOpen)
                @include('livewire.view')
            @endif
            @if($isCompleted)
                @include('livewire.completed')
            @endif
            @if($showNotifications)
                @include('livewire.notifications')
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
                                @if($task->user)
                                    {{ $task->user->name }}
                                @else
                                    Not Assigned
                                @endif
                            </td>
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center">
                                    <button wire:click="openView({{ $task->id }})" class="inline-flex items-center px-2 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-700 hover:bg-green-800 focus:outline-none focus:border-green-900 focus:shadow-outline-green active:bg-green-800 transition ease-in-out duration-150" style="background-color: #38A169;">
                                        View
                                    </button>
                                    <div style="width: 10px;"></div>
                                    <button wire:click="edit({{ $task->id }})" class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Edit
                                    </button>
                                    <div style="width: 10px;"></div>
                                    <button wire:click="delete({{ $task->id }})" class="inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-start mb-4 mt-4">
                <button wire:click="openCompleted" class="inline-flex items-center px-3 py-2 ml-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:shadow-outline-green disabled:opacity-25 transition ease-in-out duration-150" style="background-color: #38A169;">
                    Show Completed Tasks
                </button>
            </div>
        </div>
    </div>
</div>