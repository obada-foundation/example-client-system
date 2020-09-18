<?php

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
Route::get('/devices', 'SiteController@deviceList');
Route::get('/devices/{device_id}', 'SiteController@deviceDetail');
Route::get('/devices/{device_id}/edit', 'SiteController@editDevice');

Route::get('/obits', 'SiteController@obitsList');
Route::get('/obits/{obit_id}', 'SiteController@obitDetail');



Route::get('/generate/usn', 'SiteController@generateUsn');



