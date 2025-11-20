<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [DashboardController::class, 'index']);


});
