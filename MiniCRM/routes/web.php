<?php

use App\Http\Controllers\CostumerController;
use App\Http\Controllers\DealController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Customers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('customers', [CostumerController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('customer');
Route::get('deals', [DealController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('deal');

require __DIR__.'/auth.php';
