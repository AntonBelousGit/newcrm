<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;

Route::group(['middleware' => 'auth','prefix' => 'admin', 'as' => 'admin.'],
    function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::resources([
            'orders'=> OrderController::class,
        ]);
        Route::post('/orders/remove-cargo', [OrderController::class,'remove_cargo']);

    });
