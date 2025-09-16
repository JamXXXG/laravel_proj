<?php

namespace App\Livewire;

use App\Models\Customers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ShowCustomer extends Component
{
    use WithFileUploads, WithPagination;
    protected $listeners = [
        'edit' => '$refresh'
    ];
    public $newCustomer = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'notes' => '',
        'avatar_path' => '',
    ];
    public $edCustomer = [
        'id' => null,
        'name' => '',
        'email' => '',
        'phone' => '',
        'notes' => '',
        'avatar_path' => '',
    ];
    public $editCustomer = null;
    public $query = '';

    public function boot(){
        $this->editCustomer = Customers::get()->first();
    }
    public function render()
    {
         if($this->query == ''){
            $customers = Customers::paginate(5);
        } else {
            $customers = Customers::query()
                ->where('name', 'like', '%'.$this->query.'%')
                ->orWhere('email', 'like', '%'.$this->query.'%')
                ->orWhere('phone', 'like', '%'.$this->query.'%')
                ->orWhere('notes', 'like', '%'.$this->query.'%')
                ->paginate(5);

            if($customers->isEmpty()){
                session()->flash('message', 'No deals found for the search term: '.$this->query);
            }
        }
        return view('livewire.show-customer', ['customers' => $customers]);
    }

    public function search()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
       $editCustomer = \App\Models\Customers::findOrFail($id);
        $this->editCustomer = $editCustomer;
        $this->edCustomer = [
            'id' => $editCustomer->id,
            'name' => $editCustomer->name,
            'email' => $editCustomer->email,
            'phone' => $editCustomer->phone,
            'notes' => $editCustomer->notes,
            'avatar_path' => $editCustomer->avatar_path,
        ];
        
        $this->dispatch('edit');
        // dd($this->editDeal);
    }
    
    public function saveEdit()
    {
        
        $this->editCustomer = \App\Models\Customers::findOrFail($this->edCustomer['id']);

        $this->validate([
            'edCustomer.name' => 'required|string|max:255',
            'edCustomer.email' => 'required|email|unique:customers,email,'.$this->edCustomer['id'],
            'edCustomer.phone' => 'nullable|string|max:25',
            'edCustomer.notes' => 'nullable|string',
            'edCustomer.avatar_path' => 'nullable|sometimes|image|max:2048', // Max 2MB
        ]);
        DB::beginTransaction();
        try{   

            if (Str::startsWith($this->edCustomer['avatar_path'], '/storage')) {
                $this->edCustomer['avatar_path'] = $this->editCustomer->avatar_path; ;
            }else{
                
                $avatarPath = $this->edCustomer['avatar_path']->store('avatars', 'public');
                $this->edCustomer['avatar_path'] = $avatarPath;
            }

            $this->editCustomer->update([
                'name' => $this->edCustomer['name'],
                'email' => $this->edCustomer['email'],
                'phone' => $this->edCustomer['phone'],
                'notes' => $this->edCustomer['notes'],
                'avatar_path' => $this->edCustomer['avatar_path'],
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
            $del = \App\Models\Customers::findOrFail($id);
            $del->delete();
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
        return redirect(request()->header('Referer'));
    }

    public function addCustomer(){
         //
        $this->validate([
            'newCustomer.name' => 'required|string|max:255',
            'newCustomer.email' => 'required|email|unique:customers,email',
            'newCustomer.phone' => 'nullable|string|max:20',
            'newCustomer.notes' => 'nullable|string',
            'newCustomer.avatar_path' => 'nullable|sometimes|image|max:2048', // Max 2MB
        ]);
        
       
        
        DB::beginTransaction();
        try{

        if ($this->newCustomer['avatar_path']) {
            $avatarPath = $this->newCustomer['avatar_path']->store('avatars', 'public');
            $this->newCustomer['avatar_path'] = $avatarPath;
        }

            Customers::create([
                'users_id' => auth()->id(),
                'name' => $this->newCustomer['name'],
                'email' => $this->newCustomer['email'],
                'phone' => $this->newCustomer['phone'],
                'notes' => $this->newCustomer['notes'],
                'avatar_path' => $this->newCustomer['avatar_path'],
            ]);
            DB::commit();


        } catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
        return redirect(request()->header('Referer'));
    }
}
