<?php

use App\Http\Controllers\Admin\AddressesListController;
use App\Http\Controllers\Admin\AgentUserController;
use App\Http\Controllers\Admin\DriverUserController;
use App\Http\Controllers\Admin\GoogleController;
use App\Http\Controllers\Admin\PayerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InvoiceController;

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'],
    function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');
//Orders
        Route::get('/orders/new-order', [OrderController::class, 'new_order'])->name('orders.new_order');
        Route::get('/orders/archives', [OrderController::class, 'archives'])->name('orders.archives');
//        Route::get('/orders/in-processing', [OrderController::class,'in_processing'])->name('orders.in_processing');
        Route::get('/orders/in-work', [OrderController::class, 'in_work'])->name('orders.in_work');
        Route::get('/orders/delivered', [OrderController::class, 'delivered'])->name('orders.delivered');
        Route::get('/orders/return-job', [OrderController::class, 'return_job'])->name('orders.return_job');
        Route::get('/orders/canceled', [OrderController::class, 'canceled'])->name('orders.canceled');
        Route::get('/orders/create-return-job', [OrderController::class, 'create_returned_order'])->name('orders.create-return-job');
        Route::post('/orders/create-return-job', [OrderController::class, 'store_returned_order'])->name('orders.store-return-job');
        Route::get('/orders/agent/{order}', [OrderController::class, 'edit_agent_driver'])->name('orders.edit-agent');
        Route::get('/orders/driver/{order}', [OrderController::class, 'edit_agent_driver'])->name('orders.edit-driver');
        Route::post('/orders/agent/{order}', [OrderController::class, 'update_agent_driver_tracker'])->name('orders.agent-driver-tracker');
        Route::post('/orders/driver/{order}', [OrderController::class, 'update_agent_driver_tracker'])->name('orders.agent-driver-tracker');
        Route::get('/orders/duplicate/{order}', [OrderController::class, 'duplicate'])->name('orders.duplicate');
        Route::post('/orders/remove-cargo', [OrderController::class, 'remove_cargo']);
//Users
        Route::get('/users/client-payer', [PayerController::class, 'showClient'])->name('show-client');
        Route::get('/user/edit', [UserController::class, 'editClient'])->name('user.edit-client');
        Route::post('/user/edit/{id}', [UserController::class, 'updateClient'])->name('user.update-client');
        Route::get('/users/client-payer/{user}', [PayerController::class, 'clientPayerEdit'])->name('client-payer-edit');
        Route::post('/users/client-payer/{user}', [PayerController::class, 'clientPayerUpdate'])->name('client-payer-update');
//Reports
        Route::post('/reports', [ReportController::class, 'export'])->name('reports');
        Route::get('/reports', [ReportController::class, 'export'])->name('reports');
        Route::get('/reports/{report}', [ReportController::class, 'exportExist'])->name('download');
        Route::get('/print/{id}', [InvoiceController::class, 'downloadPDF'])->name('download_pdf');
        Route::post('/reports/selected-orders', [ReportController::class, 'exportSelected'])->name('selected_orders');

//Addresses list
        Route::post('/search', [AddressesListController::class, 'search'])->name('search');
        Route::get('/addresses-list/import', [AddressesListController::class, 'viewImport'])->name('view-import');
        Route::post('/addresses-list/import', [AddressesListController::class, 'import'])->name('import-address');
//Tracker
        Route::post('/tracker/child-row', [TrackerController::class, 'show_child_row'])->name('orders.children');
        Route::post('/tracker/remove-tracker', [TrackerController::class, 'remove_tracker']);

        Route::resources([
            'orders' => OrderController::class,
            'users' => UserController::class,
            'driver' => DriverUserController::class,
            'agent' => AgentUserController::class,
            'payer' => PayerController::class,
            'report' => ReportController::class,
            'addresses-list' => AddressesListController::class,
        ]);

    });
