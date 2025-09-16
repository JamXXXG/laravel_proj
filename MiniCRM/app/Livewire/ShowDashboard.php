<?php

namespace App\Livewire;

use App\Models\Customers;
use App\Models\Deal;
use App\Models\DealStatus;
use Livewire\Component;

class ShowDashboard extends Component
{
    public $deals = null; 
    public $customers = null; 
    
    public $wonDeals = null; 
    public $leadsDeals = null; 
    public $qualifiedDeals = null; 
    public $negotiatingDeals = null; 

    
    public function boot(){
        
        $dea = DealStatus::get();
        $this->deals = Deal::with('status', 'customer')->get();
        $this->customers = Customers::all()->count();
        // $this->deals = Deal::with('status', 'customer');

        $this->wonDeals = $this->deals->where('status.name', 'Won')->count();
        $this->leadsDeals = $this->deals->where('status.name', 'Lead')->count();
        $this->qualifiedDeals = $this->deals->where('status.name', 'Qualified')->count();
        $this->negotiatingDeals = $this->deals->where('status.name', 'Negotiating')->count();
        
        // $this->wonDeals = $this->deals::with('status')->whereHas('status', function($query){
        //     $query->where('name', 'Won');
        // })->count();
        // $this->leadsDeals = $this->deals::with('status')->whereHas('status', function($query){
        //     $query->where('name', 'Lead');
        // })->count();
        // $this->qualifiedDeals = $this->deals::with('status')->whereHas('status', function($query){
        //     $query->where('name', 'Qualified');
        // })->count();
        // $this->negotiatingDeals = $this->deals::with('status')->whereHas('status', function($query){
        //     $query->where('name', 'Negotiating');
        // })->count();

    }

    public function render()
    {
        return view('livewire.show-dashboard');
    }
}
