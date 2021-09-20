<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('login');
});

//Route::get('/admin', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

Route::get('/clear', function() {

    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    return "Cache Clear All";
});
Route::get('/reset', function(){
    Artisan::call('migrate:fresh', ['--seed' => true]);
    return "migrate success";

});
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
