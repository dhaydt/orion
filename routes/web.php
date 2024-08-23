<?php

use App\Http\Controllers\Controller;
use App\Models\RunningTime;
use App\Models\TransactionSummary;
use App\Models\Transaksi;
use App\Models\User;
use Filament\Notifications\Notification;
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

Route::get('/count_summary', function () {
    $dates = RunningTime::get()->pluck('created_at')->toArray();

    foreach ($dates as $key => $d) {
        $transactions = RunningTime::where('status_pembayaran', 1)->whereDate('created_at', $d)->get();
        $summary = [];
        $transaction= 0;

        foreach ($transactions as $key => $t) {
            $total = $t->total();
            array_push($summary, $total);
            $transaction += 1;
        }

        $check = TransactionSummary::wheredate('date', $d)->first();

        if(!$check){
            $check = new TransactionSummary();
            $check->date = $d->format('Y-m-d H:i');
        }

        $check->total = array_sum($summary);
        $check->transaction = $transaction;
        $check->save();
    }
    dd('calculated!');
});

Route::get('/send_notif', function () {
    $user = User::get();

    foreach ($user as $u) {
        Notification::make()
            ->title('Notifikasi dari route')
            ->sendToDatabase($u);
    }

    dd('Notif terkirim');
});

// Route::get('login', function(){
//   return redirect()->url('login');
// })->name('login');

Route::group(['middleware' => ['auth'], 'prefix' => 'cashier'], function () {
    Route::get('print/{id}', [Controller::class, 'print'])->name('print');
    Route::get('print_order/{id}', [Controller::class, 'print_order'])->name('print_order');
    Route::get('print_transaksi/{id}', [Controller::class, 'print_transaksi'])->name('print_transaksi');
});
