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
    return view('welcome');
});

Route::post('/hooks/v2rn6jd2zzj2tcEaLPGZtjgzgLMzrxqwtp3Ju9EruJIMCMePsYn3hqYVPQczFV9w', [App\Http\Controllers\EventHooksController::class, 'handle_hook']);