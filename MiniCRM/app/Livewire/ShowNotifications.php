<?php

namespace App\Livewire;

use Livewire\Component;

class ShowNotifications extends Component
{
    public function render()
    {
        return view('livewire.show-notifications');
    }

    
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        
    }  
    public function markAll()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return redirect(request()->header('Referer'));
    }   
}
