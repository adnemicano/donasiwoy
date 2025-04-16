<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\CampaignController;
use App\Http\Controllers\Frontend\CaraDonasiController;
use App\Http\Controllers\Frontend\DonationController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Campaign;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Berikut adalah tempat untuk mendaftarkan semua route aplikasi Anda.
| Route ini akan di-load oleh RouteServiceProvider.
| Semua route akan menggunakan middleware "web".
|
*/

// Route halaman utama
Route::get('/', function () {
    $campaigns = app(CampaignController::class)->latestCampaigns(); // Ambil kampanye terbaru
    $latestNews = app(FrontendNewsController::class)->latestNews(); // Ambil berita terbaru
    return view('pages.index', compact('campaigns', 'latestNews'));
})->name('home');

// Route untuk halaman frontend
Route::prefix('campaigns')->group(function () {
    Route::get('/', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');
});

// Route untuk halaman frontend news
Route::prefix('news')->group(function () {
    Route::get('/', [FrontendNewsController::class, 'index'])->name('news.index');
    Route::get('/{slug}', [FrontendNewsController::class, 'show'])->name('news.show');
});

// Route untuk halaman Cara Donasi
Route::get('/cara-donasi', [CaraDonasiController::class, 'index'])->name('cara-donasi');

// Route untuk user yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    // Initial donation process
    Route::post('/donasi', [DonationController::class, 'store'])->name('donation.store');

    // Donation details and payment method
    Route::get('/donasi/{id}/details', [DonationController::class, 'details'])->name('donation.details');
    Route::post('/donasi/{id}/process', [DonationController::class, 'processPayment'])->name('donation.process');

    // Donation status page
    Route::get('/donasi/{id}/status', [DonationController::class, 'status'])->name('donation.status');
    Route::get('/donasi/{id}/check-status', [DonationController::class, 'checkStatus'])->name('donation.check-status');

    // Tambahkan route untuk konfirmasi donasi
    Route::post('/donasi/confirm', [DonationController::class, 'confirmDonation'])->name('donation.confirm');
});
// callback route for Midtrans
Route::post('/midtrans/callback', [DonationController::class, 'midtransCallback'])->name('midtrans.callback');

// Route untuk halaman admin dengan middleware "auth"
Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Halaman dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // CRUD untuk campaigns
    Route::resource('campaigns', 'CampaignController');

    // CRUD untuk news
    Route::resource('news', 'NewsController');

    // Management donations
    Route::get('/donations', 'DonationController@index')->name('donations.index');
    Route::get('/donations/{id}', 'DonationController@show')->name('donations.show');
    Route::patch('/donations/{id}/status', 'DonationController@updateStatus')->name('donations.update-status');
    Route::get('/donations/campaign/{campaignId}', 'DonationController@campaignDonations')->name('donations.campaign');
    Route::get('/reports/donations', 'DonationController@reports')->name('donations.reports');
});

// Route untuk autentikasi
Route::prefix('auth')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

    // Register
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [FrontendUserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [FrontendUserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [FrontendUserController::class, 'update'])->name('profile.update');
    Route::get('/profile/donations', [App\Http\Controllers\Frontend\ProfileController::class, 'donation'])->name('profile.donations');
    Route::get('/profile/settings', [App\Http\Controllers\Frontend\ProfileController::class, 'settings'])->name('profile.settings');
});

Route::get('/campaign/{slug}', [CampaignController::class, 'show'])->name('campaign.show');
