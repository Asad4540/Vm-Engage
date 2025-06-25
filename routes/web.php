<?php

use App\Http\Controllers\AdCampaignController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientCampaignController;
use App\Http\Controllers\CampaignController;



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

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/logintodash', [AuthController::class, 'login'])->name('logintodash');

Route::middleware(['auth'])->group(function () {

    // Main page 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ad-campaign', [AdCampaignController::class, 'index'])->name('ad-campaign');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Client Side Routes
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/client-campaign', [ClientCampaignController::class, 'index'])->name('client-campaign');
    Route::get('/client-campaign/{hashid}/edit', [ClientCampaignController::class, 'edit'])->name('campaigns.client_edit');
    Route::get('/campaigns/export', [CampaignController::class, 'export'])->name('campaigns.export');



    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');



    Route::middleware(['auth', 'isSales'])->group(function () {
        // Client Routes 
        Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');

        // Campaign Routes 
        Route::get('/ad-campaign', [AdCampaignController::class, 'index'])->name('ad-campaign');
        Route::post('/ad-campaign/store', [AdCampaignController::class, 'store'])->name('campaign.store');
        Route::delete('/ad-campaign/{id}', [AdCampaignController::class, 'destroy'])->name('campaign.destroy');

        Route::get('/ad-campaign/{hashid}/edit', [AdCampaignController::class, 'edit'])->name('campaigns.edit');
        Route::post('/ad-campaign/{campaign}/update', [AdCampaignController::class, 'update'])->name('campaigns.update');
        Route::post('/ad-campaign/{campaign}/save', [AdCampaignController::class, 'save'])->name('ad-campaign.update');

        // Client Routes 
        Route::get('/clients/{hashid}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::post('/clients/{hashid}/update', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{hashid}', [ClientController::class, 'destroy'])->name('clients.destroy');

        //Admin Routes
        Route::middleware(['auth', 'isAdmin'])->group(function () {

            //User routes
            Route::get('/users', [UsersController::class, 'index'])->name('users');
            Route::post('/createuser', [UsersController::class, 'create'])->name('createuser');
            Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
            Route::get('/users/{id}', [UsersController::class, 'edit']);
            Route::put('/users/{id}', [UsersController::class, 'update']);

        });
    });

});





