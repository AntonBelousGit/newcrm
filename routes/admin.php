<?php

use App\Http\Controllers\Admin\TrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

Route::group(['middleware' => 'auth','prefix' => 'admin', 'as' => 'admin.'],
    function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::get('/orders/new-order', [OrderController::class,'new_order'])->name('orders.new_order');
        Route::get('/orders/in-processing', [OrderController::class,'in_processing'])->name('orders.in_processing');
        Route::get('/orders/in-work', [OrderController::class,'in_work'])->name('orders.in_work');
        Route::get('/orders/delivered', [OrderController::class,'delivered'])->name('orders.delivered');
        Route::resources([
            'orders'=> OrderController::class,
            'users'=> UserController::class,
//            'tracker'=> TrackerController::class,
        ]);
        Route::post('/orders/remove-cargo', [OrderController::class,'remove_cargo']);
        Route::post('/tracker/remove-tracker', [TrackerController::class,'remove_tracker']);
    });
