<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\CampaignController;
use App\Http\Controllers\Frontend\CaraDonasiController;
use App\Http\Controllers\Frontend\DonationController;
use App\Models\Campaign;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
})->name('home');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
Route::get('/campaigns/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');

Route::get('/cara-donasi', [CaraDonasiController::class, 'index'])->name('cara-donasi');

Route::middleware(['auth'])->group(function () {
    Route::post('/donasi', [DonationController::class, 'store'])->name('donation.store');
});


Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->middleware(['auth'])->name('admin.')->group(function () {
    // membuat route untuk halaman dashboard, ketika user mengakses /admin
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('campaigns', 'CampaignController');
});

// membuat route untuk halaman login, ketika user mengakses /login
// maka akan diarahkan ke LoginController dengan method index
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

// membuat route untuk halaman login, ketika user mengakses /register
// maka akan diarahkan ke LoginController dengan method index
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// membuat route untuk halaman login, ketika user mengakses /logout
// maka akan diarahkan ke LoginController dengan method index
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
