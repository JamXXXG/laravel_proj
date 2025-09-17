<div class="p-4">

    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    @if ($customers)
        <flux:heading size="lg" class="mb-4">Customers List</flux:heading>
        <flux:input 
            label="Search Customers" 
            placeholder="Search by Name, Email, Phone..." 
            wire:model.debounce.300ms="query" 
            wire:keydown.debounce.400ms="search"
            class="mb-4"
        />
        <table class="w-full border-collapse table-auto">
            <thead>
                <tr>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">pic</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Name</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Email</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Phone</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notes</th>
                    <th class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="hover:bg-blue-50 dark:hover:bg-blue-800 odd:bg-gray-900/50">
                    
                        @if (Str::startsWith($customer['avatar_path'], 'avatars/'))
                            <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                <div class="mt-2">
                                    <img src="{{asset('storage/'.$customer['avatar_path'])}}" alt="Avatar Preview" class="h-20 w-20 object-cover rounded-full">
                                </div>
                            </td>
                        @else 
                            <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                <div class="mt-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer['name']) }}&size=128" alt="Avatar Preview" class="h-10 w-10 object-cover rounded-full">
                                </div>
                            </td>
                        @endif
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $customer->name }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $customer->email }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $customer->phone }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $customer->notes }}</td>
                        <td class="border-b border-zinc-200 dark:border-zinc-700 px-4 py-2 text-sm text-zinc-900 dark:text-zinc-100"><flux:dropdown>
                            <flux:button icon:trailing="chevron-down">...</flux:button>
                                <flux:menu>
                                    <flux:modal.trigger name="edit" wire:navigate><flux:menu.item icon="plus" wire:click="edit({{$customer->id}})" wire:navigate>Edit Customer Info</flux:menu.item></flux:modal.trigger>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="delete({{$customer->id}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$customers->links()}}
    @endif

    
        <flux:separator />
         <div class="mt-8 px-4 py-4">
            <flux:heading size="md" class="mb-2">Add New Customer</flux:heading>
            <form wire:submit.prevent="addCustomer" enctype="multipart/form-data">
                @csrf
                <flux:input label="Name" id="name" placeholder="Customer Name" wire:model.defer="newCustomer.name" required/>
                <flux:input type="email" label="Email" id="email" placeholder="Email" wire:model.defer="newCustomer.email" required/> 
                <flux:input label="Phone" id="phone" placeholder="Phone Number" wire:model.defer="newCustomer.phone"/>
                <flux:textarea label="Notes" id="notes" placeholder="Additional Notes" wire:model.defer="newCustomer.notes"/>
                <flux:input type="file" label="Avatar" id="avatar_path" wire:model="newCustomer.avatar_path" accept="image/*" />
                @if ($newCustomer['avatar_path'])
                    <div class="mt-2">
                        <img src="{{ $newCustomer['avatar_path']->temporaryUrl() }}" alt="Avatar Preview" class="h-20 w-20 object-cover rounded-full">
                    </div>
                @endif
                <div class="flex mt-4">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Add Customer</flux:button>
                </div>
            </form>
        </div>

        @if ($editCustomer)
            <flux:modal name="edit" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Update profile</flux:heading>
                        <flux:text class="mt-2">Make changes to your personal details.</flux:text>
                    </div>
                    <form wire:submit.prevent="saveEdit" enctype="multipart/form-data">
                    @csrf

                        <flux:input label="Customer Name" id="customer_name" placeholder="Customer Name" value="{{$editCustomer->name}}" wire:model.defer="edCustomer.name"></flux:input>
                        <flux:input label="Email" type="email" id="status1" placeholder="Email" value="{{$editCustomer->email}}" wire:model.defer="edCustomer.email"></flux:input>

                        <flux:input label="Phone" placeholder="Phone" name="ephone" value="{{$editCustomer->phone}}" wire:model.defer="edCustomer.phone" />
                        <flux:textarea label="Notes" name="notes" value="{{$editCustomer->notes}}" wire:model.defer="edCustomer.notes" />
                        <flux:input type="file" label="Avatar" id="avatar_path" wire:model.defer="edCustomer.avatar_path" accept="image/*" />
                        <div class="flex">
                            <flux:spacer />
                            <flux:modal.close><flux:button type="submit" variant="primary">Save changes</flux:button></flux:modal.close>
                        </div>
                        
                    </form>
                </div>
            </flux:modal>
        @endif

</div>
