<div>
    {{-- Success is as dangerous as failure. --}}
    <h1 class="text-2xl font-bold mb-4 px-4 py-4">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4 py-4">
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Total Customers</h2>
            <p class="text-3xl">{{$customers}}</p>
        </div>
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Total Deals</h2>
            <p class="text-3xl">{{count($deals)}}</p>
        </div>
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Negotiating Deals</h2>
            <p class="text-3xl">{{ $negotiatingDeals }}</p>
        </div>
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Won Deals</h2>
            <p class="text-3xl">{{ $wonDeals }}</p>
        </div>
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Leads</h2>
            <p class="text-3xl">{{ $leadsDeals }}</p>
        </div>  
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Qualified Deals</h2>
            <p class="text-3xl">{{ $qualifiedDeals }}</p>
        </div>  
        
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Total Won Amount:</h2>
            <p class="text-3xl">{{ $totalWonAmount }}</p>
        </div>  
        
        <div class="bg-black p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Total Potential Amount:</h2>
            <p class="text-3xl">{{ $totalUnwonAmount }}</p>
        </div>  
    </div>
</div>
