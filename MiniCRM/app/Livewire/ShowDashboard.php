<?php

namespace App\Livewire;

use App\Models\Customers;
use App\Models\Deal;
use App\Models\DealStatus;
use App\Models\TryPolyDeals;
use Livewire\Component;

class ShowDashboard extends Component
{
    public $deals = null; 
    public $customers = null; 
    public $poly = null; 
    
    public $wonDeals = null; 
    public $leadsDeals = null; 
    public $qualifiedDeals = null; 
    public $negotiatingDeals = null; 

    
    public $totalWonAmount = null; 
    public $totalUnwonAmount = null; 


    
    public function boot(){
        
        $this->deals = Deal::with('status', 'customer')->where(['users_id' => auth()->id()])->get();
        $this->customers = Customers::where(['users_id' => auth()->id()])->count();
        // $this->poly = TryPolyDeals::with('dealable', 'status', 'user')->get();

        //dis for poly try
        // $this->customers = Customers::with('trydeals')->get();
        // dd($this->customers[14]->trydeals[0]->won_at); 

        // $this->deals = Deal::with('status', 'customer');

        $this->wonDeals = $this->deals->where('status.name', 'Won')->count();
        $this->leadsDeals = $this->deals->where('status.name', 'Lead')->count();
        $this->qualifiedDeals = $this->deals->where('status.name', 'Qualified')->count();
        $this->negotiatingDeals = $this->deals->where('status.name', 'Negotiating')->count();

        
        $this->totalWonAmount = $this->deals->sum('amount');
        $this->totalUnwonAmount = $this->deals->where('status.name','!=', 'Won')->sum('amount');
        

    }

    public function render()
    {
        return view('livewire.show-dashboard');
    }
}
