<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400 flex items-center justify-center">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" wire:click="closeView">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-96 p-6" 
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                @if($task)
                <div class="flex flex-wrap -mx-2">
                    <div class="w-1/2 px-2 mb-4">
                            <div class="border-b pb-4">
                                <label class="block text-gray-700 text-lg font-bold mb-2">Task Name:</label>
                                <span class="text-gray-900">{{ $task->name }}</span>
                            </div>
                            <div class="border-b pb-4">
                                <label class="block text-gray-700 text-lg font-bold mb-2">Description:</label>
                                <span class="text-gray-900">{{ $task->description }}</span>
                            </div>
                            <div class="border-b pb-4">
                                <label class="block text-gray-700 text-lg font-bold mb-2">Category:</label>
                                <span class="text-gray-900">{{ $task->category }}</span>
                            </div>
                        </div>
                        <div class="w-1/2 px-2 mb-4">
                            <div class="border-b pb-4">
                                <label class="block text-gray-700 text-lg font-bold mb-2">Due Date:</label>
                                <span class="text-gray-900">{{ $task->due_date }}</span>
                            </div>
                            <div class="border-b pb-4">
                                <label class="block text-gray-700 text-lg font-bold mb-2">Priority Level:</label>
                                <span class="text-gray-900">{{ $task->priority_level }}</span>
                            </div>
                            <div class="border-b pb-4">
                                <label class="block text-gray-700 text-lg font-bold mb-2">Assignee:</label>
                                <span class="text-gray-900">{{ $task->user->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="border-b pb-4"></div>
                        <div class="mt-6">
                            <h2 class="text-xl font-bold mb-4">Comments</h2>
                            <div>
                                @foreach($comments as $comment)
                                    <div style="display: flex; align-items: center;">
                                        <div>
                                            <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                                        </div>
                                        <button wire:click="deleteComment({{ $comment->id }})" style="background: none; border: none; margin-left: auto;">x</button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-b pb-4"></div>
                            <form form wire:submit.prevent="addComment({{ $task->id }})">
                                <textarea wire:model="commentContent" class="w-full h-20 border p-2 mb-4" placeholder="Type your comment here"></textarea>
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button wire:click.prevent="completeTask({{ $task->id }})" type="button" class="inline-flex items-center px-3 py-2 ml-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:shadow-outline-green disabled:opacity-25 transition ease-in-out duration-150" style="background-color: #38A169;">
                                        Complete Task
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-3 py-2 ml-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150" style="background-color: #3490dc;">
                                        Add Comment
                                    </button>
                                </span>
                            </form>
                        </div>
                </div>
                @endif
        </div>
    </div>
</div>