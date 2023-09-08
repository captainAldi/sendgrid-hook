<?php

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
    return redirect()->route('login');
})->name('awal');


// Add Verify Page to Auth Scaffolding
Auth::routes(['verify' => true]);


// Sendgrid Webhooks
Route::post('/hooks/' . env('SENDGRID_HOOK_ENDPOINT'), [App\Http\Controllers\EventHooksController::class, 'handle_hook']);


// No Prefix and Auth Middleware
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/hooks/coba-kirim-email', [App\Http\Controllers\EventHooksController::class, 'test_kirim_email']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/data-event/delivery', [App\Http\Controllers\DeliveryEventController::class, 'index'])->name('get.delivery-event');
    Route::get('/data-event/delivery/detail/{message_id}', [App\Http\Controllers\DeliveryEventController::class, 'detail'])->name('get.delivery-event.detail');

    Route::resource('sender-identity', App\Http\Controllers\SenderIdentityController::class);

});


