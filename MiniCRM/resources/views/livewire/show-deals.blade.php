<div class="p-4">

    @if ($deals)
    <div class="mb-4 px-4 py-4">
        <flux:heading size="lg" class="mb-4">Deals List</flux:heading>
        <flux:input 
            label="Search Deals" 
            placeholder="Search by Status, Amount, Title..." 
            wire:model.live.debounce.300ms="query" 
            {{-- wire:keydown.debounce.400ms="search" --}}
            class="mb-4"
        />
        <table class="w-full border-collapse table-auto">
            <thead>
                <tr>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Customer</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Status</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Email</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Amount</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Expected Close</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Won At</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deals as $deal)
                    <tr class="hover:bg-blue-50 dark:hover:bg-blue-800">
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $deal->customer->name }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $deal->status->name }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $deal->customer->email }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $deal->amount }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $deal->expected_close_at }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $deal->won_at }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">...</flux:button>
                                <flux:menu>
                                    <flux:modal.trigger name="edit" wire:navigate><flux:menu.item icon="plus" wire:click.prevent="edit({{$deal->id}})" wire:navigate >Edit Deal Info</flux:menu.item></flux:modal.trigger>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click.prevent="delete({{$deal->id}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$deals->links()}}
    </div>
        <flux:separator />
         <div class="mt-8 px-4 py-4">
            <flux:heading size="md" class="mb-2">Add New Deal</flux:heading>
            <form wire:submit="addDeal">
                @csrf
                <flux:input label="Title" id="title" placeholder="Deal Title" wire:model.defer="newDeal.title" required/>
                <flux:input label="Amount" id="amount" placeholder="Deal Amount" wire:model.defer="newDeal.amount" required/> 
                {{-- Customer Dropdown --}}
                <flux:select label="Customer" id="customer_id" wire:model.defer="newDeal.customer_id" >
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </flux:select>
                 {{-- Status Dropdown --}}
                <flux:select label="Customer" id="status_id" wire:model.defer="newDeal.status_id" required>
                    <option value="">Select Status</option>
                    @foreach($stats as $stat)
                        <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                    @endforeach
                </flux:select>
                <flux:input 
                    label="Expected Close Date" 
                    id="expected_close_at" 
                    type="date" 
                    wire:model.defer="newDeal.expected_close_at" 
                    :min="date('Y-m-d', strtotime('+1 day'))"
                />
                <div class="flex mt-4">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Add Deal</flux:button>
                </div>
            </form>
        </div>

        
        @if ($editDeal)
            <flux:modal name="edit" class="md:w-96" :dismissable="false">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Update profile</flux:heading>
                        <flux:text class="mt-2">Make changes to your personal details.</flux:text>
                    </div>
                    <form wire:submit.prevent="saveEdit">
                    @csrf

                        <flux:input label="Customer Name" id="customer_name" placeholder="Customer Name" disabled wire:model="editDealAttribs.customer_name"></flux:input>
                        <flux:input label="Status" id="status1" placeholder="Status" disabled wire:model="editDealAttribs.status"></flux:input>

                        <flux:input label="Title" placeholder="Title" name="title" value="{{$editDeal->title}}" wire:model.defer="editDealAttribs.title" />
                        <flux:input label="Amount" name="amount" value="{{$editDeal->amount}}" wire:model.defer="editDealAttribs.amount" 
                         />
                        {{-- Status Dropdown --}}
                        <flux:select label="Status" id="estatus_id" wire:model.defer="editDealAttribs.status_id" required 
                        >
                            <option value="{{$editDeal->status_id}}">{{$editDeal->name}}</option>
                            <option value="">Select Status</option>
                            @foreach($stats as $stat)
                                <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                            @endforeach
                        </flux:select>
                        
                        <flux:input value="{{$editDeal->expected_close_at}}" label="Expected Close Date" id="eexpected_close_at" type="date" wire:model.defer="editDealAttribs.expected_close_at" 
                        />
                        @if($editDealAttribs['status'] != 4 && $editDealAttribs['status'] != 5)
                            <div class="flex">
                                <flux:spacer />
                                <flux:modal.close><flux:button type="submit" variant="primary" 
                                >Save changes</flux:button></flux:modal.close>
                            </div>
                        @endif
                        
                    </form>
                </div>
            </flux:modal>
        @endif
    @endif
</div>
