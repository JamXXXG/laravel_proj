<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination; 

class ShowNotifications extends Component
{
    use withPagination;
    public function boot(){
    }
    public function render()
    {
        // dd($this->notifications);
        
        $notifications = auth()->user()->unreadNotifications()->latest()->paginate(5);
        return view('livewire.show-notifications', ['notifications' => $notifications]);
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
