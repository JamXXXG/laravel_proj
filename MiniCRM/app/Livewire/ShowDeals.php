<?php

namespace App\Livewire;

use App\Models\Customers;
use App\Models\Deal;
use App\Models\DealStatus;
use App\Models\User;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowDeals extends Component
{
    use WithPagination;
    protected $listeners = [
        'edit' => '$refresh'
    ];

    public $editDeal = null;
    public $customers = null;
    public $stats = null;
    public $user = null;
    public $newDeal = [
        'title' => '',
        'amount' => '',
        'customer_id' => '',
        'status_id' => '',
        'expected_close_at' => null,
        'won_at' => null,
    ];

    
    public $editDealAttribs = [
        'id' => null,
        'title' => '',
        'amount' => '',
        'status_id' => '',
        'expected_close_at' => null,
        'won_at' => null,
        'customer_name' => '',
        'status' =>  '',
    ];

    public $query = '';
    
    public function boot(){
        $this->editDeal = Deal::with(['status', 'customer'])->get()->first();
        $this->customers = Customers::get();
        $this->stats = DealStatus::get();
        $this->user = User::get();
    }

    public function render()
    {
        if($this->query == ''){
            $deals = Deal::paginate(5);
            // dd(Deal::get()[0]->customer);
        } else {
            $deals = Deal::query()
                ->where('title', 'like', '%'.$this->query.'%')
                ->orWhereHas('status', function($q){
                    $q->where('name', 'like', '%'.$this->query.'%');
                })
                ->orWhereHas('customer', function($q){
                    $q->where('name', 'like', '%'.$this->query.'%');
                })
                ->orWhere('amount', 'like', '%'.$this->query.'%')
                ->paginate(5);

            if($deals->isEmpty()){
                session()->flash('message', 'No deals found for the search term: '.$this->query);
            }
        }
        return view('livewire.show-deals', ['deals' => $deals]);
    }

    public function search()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $editDeal = Deal::with(['customer'])->findOrFail($id);
        $this->editDeal = $editDeal;
        $this->editDealAttribs = [
            'id' => $editDeal->id,
            'title' => $editDeal->title,
            'amount' => $editDeal->amount,
            'status_id' => $editDeal->deal_status_id,
            'expected_close_at' => $editDeal->expected_close_at,
            'won_at' => $editDeal->won_at,
            'customer_name' =>  $editDeal->customer->name,
            'status' =>  $editDeal->deal_status_id,
        ];



    }
    
    public function saveEdit()
    {
        // $this->editDeal;
        // dd($this->editDeal);
        
        $editDeal = Deal::with(['customer'])->findOrFail($this->editDealAttribs['id']);

        if($this->editDealAttribs['status_id'] == 4 && $this->editDealAttribs['won_at'] == null){ // if status is "Won" and won_at is null
            $this->editDealAttribs['won_at'] = Carbon::now();
        }

        DB::beginTransaction();
        try{

            $this->validate([
                'editDealAttribs.title' => 'required|string|max:255',
                'editDealAttribs.amount' => 'required|integer',
                'editDealAttribs.status_id' => 'required|exists:deal_statuses,id',
                'editDealAttribs.expected_close_at' => 'date|after:today|nullable',
            ]);


            $editDeal ->update([
                'title' => $this->editDealAttribs['title'],
                'amount' => $this->editDealAttribs['amount'],
                'deal_status_id' => $this->editDealAttribs['status_id'],
                'expected_close_at' => $this->editDealAttribs['expected_close_at'],
                'won_at' => $this->editDealAttribs['won_at'],
            ]);
            DB::commit();

        } catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }






        return redirect(request()->header('Referer'));
    }
    
    public function delete($id)
    {
        DB::beginTransaction();
        try{
            $deal = Deal::findOrFail($id);
            $deal->delete();
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
        return redirect(request()->header('Referer'));
    }

    public function addDeal(){
         //
      $this->validate([
            'newDeal.title' => 'required|string|max:255',
            'newDeal.amount' => 'required|numeric',
            'newDeal.customer_id' => 'required|exists:customers,id',
            'newDeal.status_id' => 'required|exists:deal_statuses,id',
            'newDeal.expected_close_at' => 'date|after:today|nullable',
        ]);

        DB::beginTransaction();
        try{

            if($this->newDeal['status_id'] == 4){ // if status is "Won"
                $this->newDeal['won_at'] = Carbon::now();
            }

            Deal::create([
                'users_id' => auth()->id(),
                'title' => $this->newDeal['title'],
                'amount' => $this->newDeal['amount'],
                'customers_id' => $this->newDeal['customer_id'],
                'deal_status_id' => $this->newDeal['status_id'],
                'expected_close_at' => $this->newDeal['expected_close_at'],
                'won_at' => $this->newDeal['won_at'],
            ]);
            DB::commit();


        } catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
        return redirect(request()->header('Referer'));
    }
 
      
}
