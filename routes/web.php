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
    // Donasi
    Route::post('/donasi', [DonationController::class, 'store'])->name('donation.store');
    Route::post('/donasi/confirm', [DonationController::class, 'confirmDonation'])->name('donation.confirm');
});

// Route untuk halaman admin dengan middleware "auth"
Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Halaman dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // CRUD untuk campaigns
    Route::resource('campaigns', 'CampaignController');

    Route::resource('news', 'NewsController');
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
});
