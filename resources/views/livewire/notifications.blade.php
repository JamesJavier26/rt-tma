<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400 flex items-center justify-center" wire:poll="refreshNotifications">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" wire:click="closeNotifications">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-100 p-6" 
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="mt-8" wire:poll="refreshNotifications">
                <h2 class="text-xl font-bold mb-4">Notifications</h2>
                <ul>
                    @forelse(Auth::user()->notifications()->paginate(10) as $notification)
                        <li class="mb-2">
                            @if(isset($notification->data['user_name']) && isset($notification->data['task_id']) && isset($notification->data['task_name']))
                                <a href="#" wire:click.prevent="openView({{ $notification->data['task_id'] }})" @unless($notification->read_at) class="font-bold" @endunless>
                                    <b>{{ $notification->data['user_name'] }}</b> commented on your task: <b>"{{ $notification->data['task_name'] }}"</b>
                                </a>
                            @else
                                New notification without user_name key
                            @endif
                        </li>
                    @empty
                        <li>No notifications</li>
                    @endforelse
                </ul>
                {{ Auth::user()->notifications()->paginate(10)->links() }}
            </div>
        </div>
    </div>
</div>
