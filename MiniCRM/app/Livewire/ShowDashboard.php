<?php

namespace App\Livewire;

use App\Models\Customers;
use App\Models\Deal;
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
        $this->deals = Deal::class;
        $this->customers = Customers::class;
        // $this->deals = Deal::with('status', 'customer');
        
        $this->wonDeals = $this->deals::with('status')->whereHas('status', function($query){
            $query->where('name', 'Won');
        })->count();
        $this->leadsDeals = $this->deals::with('status')->whereHas('status', function($query){
            $query->where('name', 'Leads');
        })->count();
        $this->qualifiedDeals = $this->deals::with('status')->whereHas('status', function($query){
            $query->where('name', 'Qualified');
        })->count();
        $this->negotiatingDeals = $this->deals::with('status')->whereHas('status', function($query){
            $query->where('name', 'Negotiating');
        })->count();
    }

    public function render()
    {
        return view('livewire.show-dashboard', ['deals' => $this->deals]);
    }
}
