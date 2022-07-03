<?php

use App\Http\Handlers\Devices\Documents\Store;
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

Route::get('/', 'SiteController@welcome');
Route::get('/documentation', 'SiteController@documentation')->name('documentation');
Route::get('/wallet', 'SiteController@wallet')->name('wallet');
Route::get('/retrieve/obit', 'SiteController@retrieveObit');

Route::namespace('\App\Http\Handlers\Obits')
    ->name('obits.')
    ->prefix('obits')
    ->group(function () {
        Route::get('/', function(Request $request) {
            return Redirect::to(route('devices.index'));
        });
        Route::get('/load-all', \LoadAll::class)->name('load-all');
        Route::post('/', \Store::class)->name('store');
        Route::get('/{key}', \Show::class)->name('show');
        Route::get('/{key}/to-chain', \ToChain::class)->name('to-chain');
        Route::get('/{key}/from-chain', \FromChain::class)->name('from-chain');
    });

Route::namespace('\App\Http\Handlers\Accounts')
    ->name('accounts.')
    ->prefix('accounts')
    ->middleware('auth')
    ->group(function () {
        Route::get('/balance', \Balance::class)->name('balance');
    });

Route::namespace('\App\Http\Handlers\Devices')
    ->name('devices.')
    ->prefix('devices')
    ->middleware('auth')
    ->group(function () {
        Route::get('/create', \Create::class)->name('create');
        Route::get('/load-all', \LoadAll::class)->name('load-all');
        Route::get('/{usn}', \Show::class)->name('show');
        Route::get('/{usn}/load', \Load::class)->name('load');
        Route::get('/{usn}/edit', \Edit::class)->name('edit');
        Route::get('/{usn}/transfer', \Transfer::class)->name('transfer');
        Route::get('/', \Index::class)->name('index');
        Route::post('/', \Save::class)->name('save');

        Route::namespace('Documents')
            ->name('documents.')
            ->prefix('documents')
            ->group(function () {
                Route::post('/', \Store::class)->name('store');
            });
    });

Route::namespace('\App\Http\Handlers\Generate')
    ->name('generate.')
    ->prefix('generate')
    ->group(function () {

        // USN generation tool routes
        Route::namespace('Usn')
            ->name('usn.')
            ->prefix('usn')
            ->group(function () {
                Route::get('/', Index::class)->name('index');
                Route::post('/', Compute::class)->name('compute');
            });

        // Checksum generation tool routes
        Route::namespace('Checksum')
            ->name('checksum.')
            ->prefix('checksum')
            ->group(function () {
                Route::get('/', Index::class)->name('index');
                Route::post('/', Compute::class)->name('compute');
            });
    });

Route::namespace('\App\Http\Handlers\Login')
    ->group(function () {
        Route::name('login.')
            ->prefix('login')
            ->group(function () {
                Route::get('/', \Index::class)->name('index');
                Route::post('/', \Authenticate::class)->name('auth');
            });

        Route::get('/logout', \Logout::class)->name('logout');
    });

if (config('settings.enable_registration')) {
    Route::namespace('\App\Http\Handlers\Register')
        ->name('register.')
        ->prefix('register')
        ->group(function () {
            Route::get('/', \Index::class)->name('index');
            Route::post('/', \RegisterUser::class)->name('user');
        });
}
