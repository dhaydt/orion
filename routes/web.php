<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/storage-link', function () {
  Artisan::call('storage:link');
  dd('Storage linked!');
});

Route::get('/config-cache', function () {
  Artisan::call('config:cache');
  dd('config cleared!');
});
Route::get('/migrate', function () {
  Artisan::call('migrate', [
      '--force' => true,
  ]);
  dd('migrated!');
});

// Route::get('login', function(){
//   return redirect()->url('login');
// })->name('login');

Route::group(['middleware' => ['auth'], 'prefix' => 'cashier'], function () {
  Route::get('print/{id}', [Controller::class, 'print'])->name('print');
  Route::get('print_order/{id}', [Controller::class, 'print_order'])->name('print_order');
  Route::get('print_transaksi/{id}', [Controller::class, 'print_transaksi'])->name('print_transaksi');
});