<div class="p-4">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    @if(Auth::user()->unreadNotifications->count() > 0)
        <flux:modal.trigger name="notifications" wire:navigate>
            <div class="flex items-center">
                <flux:icon.bell/>Notifications 
                <span class="bg-red-600 text-white text-xs font-semibold ml-2 px-2.5 py-0.5 rounded-full">{{ Auth::user()->unreadNotifications->count() }}
                </span>
            </div> 
        </flux:modal.trigger>

        <flux:modal name="notifications" class="md:w-96" :dismissable="true">
            <flux:heading size="lg"> {{ __('Notifications (showing 5 oldest results)') }} </flux:heading>
            @foreach(Auth::user()->unreadNotifications as $notification)
                <p class="bg-blue-100 text-blue-800 p-4 rounded mb-4" wire:click="markAsRead('{{ $notification->id }}')">
                    New Deal Won: {{ $notification->data['title'] }} from {{{$notification->data['customer_name']}}} for {{ $notification->data['amount'] }}!
                </p>
                @if($loop->index == 4)
                    @break
                @endif
                @if($loop->last)
                    <flux:spacer />
                @endif
            @endforeach
            <a class="text-sm text-black bg-blue-10" wire:click="markAll()" wire:refresh>Click here to mark all as read.</a>
        </flux:modal>

    @endif
     
</div>
