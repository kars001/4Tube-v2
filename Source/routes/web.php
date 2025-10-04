<?php

use App\Http\Controllers\TwoFactorAuthController;
use Illuminate\Support\Facades\Route;
use App\Livewire\SettingsPage;
use App\Livewire\HomePage;
use App\Livewire\UploadPage;
use App\Livewire\ProfilePage;
use App\Livewire\VideoPage;
use App\Livewire\HistoryPage;
use App\Livewire\LikedPage;
use App\Livewire\SearchPage;
use App\Livewire\TrendingPage;
use App\Livewire\SubscriptionPage;
use App\Livewire\ManagePage;


Route::get('/', HomePage::class)
    ->name('home');


Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/upload', UploadPage::class)
    ->middleware(['auth', 'verified'])
    ->name('upload');


Route::get('/settings', SettingsPage::class)
    ->middleware(['auth', 'verified'])
    ->name('settings');


Route::get('/@{name}', ProfilePage::class)
    ->name('profile');

Route::get('/watch/{slug}', VideoPage::class)
    ->name('video');

Route::get('/history', HistoryPage::class)
    ->middleware(['auth', 'verified'])
    ->name('history');

Route::get('/liked', LikedPage::class)
    ->middleware(['auth', 'verified'])
    ->name('liked');

Route::get('/search', SearchPage::class)
    ->name('search');

Route::get('/trending', TrendingPage::class)
    ->name('trending');

Route::get('/subscriptions', SubscriptionPage::class)
    ->name('subscriptions');

Route::get('/manage', ManagePage::class)
    ->name('manage');

// Route if no token then redirect to password request
Route::get('/reset-password', function () {
    return redirect()->route('password.request');
});

Route::post('/2fa-confirm', [TwoFactorAuthController::class, 'confirm'])->name('two-factor.confirm');
