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
Route::get('/retrieve/obit', 'SiteController@retrieveObit');
Route::get('/verify', 'SiteController@verify')->name('verify');
Route::get('/verify/certificate', 'SiteController@certificate')->name('timestamp-certificate');

Route::namespace('\App\Http\Handlers\Wallet')
    ->name('wallet.')
    ->prefix('obd')
    ->middleware('auth')
    ->group(function () {
        Route::middleware(['ch-token', 'ch-account'])
            ->get('/{address}', \Index::class)->name('index');

        Route::post('/{address}', \Send::class)->name('send');
    });

Route::namespace('\App\Http\Handlers\NFT\Transfer')
    ->name('nft.transfer.')
    ->prefix('nft')
    ->middleware('auth')
    ->group(function () {
        Route::middleware(['ch-token', 'ch-account'])
            ->get('/{usn}/transfer', \Index::class)
            ->name('index');

        Route::post('/{usn}/transfer', \Send::class)->name('send');
    });

Route::namespace('\App\Http\Handlers\NFT')
    ->name('nft.')
    ->prefix('nft')
    ->middleware('auth')
    ->group(function () {
        Route::get('/{address}/mint-all', \MintAll::class)->name('mint-all');
        Route::post('/{usn}/mint', \Mint::class)->name('mint');
        Route::post('/{usn}/metadata', \UpdateMetadata::class)->name('update-metadata');
    });

Route::namespace('\App\Http\Handlers\Obits')
    ->name('obits.')
    ->prefix('obits')
    ->group(function () {
        Route::get('/', fn(Request $request) => Redirect::to(route('devices.index')));
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
        Route::get('/', \Index::class)->name('index');
        Route::get('/manage', \Manage::class)->name('manage');
        Route::get('/import-account', \ImportAccount::class)->name('import-account');
        Route::get('/generate-phrase', \GeneratePhrase::class)->name('generate-phrase');
        Route::post('/save-phrase', \SavePhrase::class)->name('save-phrase');
        Route::post('/import-wallet', \ImportWallet::class)->name('import-wallet');
        Route::post('/import-account-post', \ImportAccountPost::class)->name('import-account-post');
        Route::get('/export-account/{address}', \ExportAccount::class)->name('export-account');
        Route::post('/new-account', \StoreAccount::class)->name('new-account');
        Route::post('/{address}', \UpdateAccount::class)->name('update-account');

        Route::middleware(['ch-token', 'ch-account'])
            ->get('/{address}/delete', \DeleteAccount::class)
            ->name('delete-account');

        Route::get('/balance', \Balance::class)->name('balance');
    });

Route::namespace('\App\Http\Handlers\Devices')
    ->name('devices.')
    ->prefix('devices')
    ->middleware('auth')
    ->group(function () {

        Route::get('/load-all', \LoadAll::class)->name('load-all');
        Route::get('/{usn}/load', \Load::class)->name('load');
        Route::post('/', \Save::class)->name('save');

        Route::middleware(['ch-token', 'ch-account'])
            ->group(function () {
                Route::get('/{address}', \Index::class)->name('index');
                Route::get('/{address}/create', \Create::class)->name('create');
                Route::get('/{usn}/edit', \Edit::class)->name('edit');
                Route::get('/{usn}/show', \Show::class)->name('show');
            });

        Route::namespace('Import')
            ->name('import.')
            ->group(function () {
                Route::middleware(['ch-token', 'ch-account'])
                    ->get('/{address}/import', Index::class)
                    ->name('index');

                Route::post('/{address}/import', HandleImport::class)->name('handle');
            });

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
