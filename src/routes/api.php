<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function(){
    Route::get('/data/devices', 'DataController@get_devices_data');
    Route::get('/data/obits', 'DataController@get_obits_data');

    Route::get('/internal/devices', 'ServiceController@getDevices');
    Route::get('/internal/device/{device_id}', 'ServiceController@getDeviceById');
    Route::get('/internal/obit/{usn}', 'ServiceController@getObitByUsn');


    Route::post('internal/document/upload', 'ServiceController@uploadDocument');
    Route::post('internal/device', 'ServiceController@saveDevice');
    Route::post('internal/device/obit', 'ServiceController@createObit');
    Route::post('internal/obit/sync', 'ServiceController@syncObit');
    Route::post('internal/obit', 'ServiceController@retrieveObit');
    Route::post('internal/obit/device', 'ServiceController@mapObitToDevice');
    Route::post('internal/usn', 'ServiceController@generateUsn');
    Route::post('internal/device/metadata', 'ServiceController@saveDeviceMetadata');
    Route::post('internal/device/document', 'ServiceController@saveDeviceDocument');
    Route::post('internal/device/structured_data', 'ServiceController@saveDeviceStructuredData');

    Route::delete('/internal/device/{device_id}', 'ServiceController@removeDevice');
    Route::delete('/internal/device/{device_id}/metadata/{metadata_id}', 'ServiceController@removeDeviceMetadata');
    Route::delete('/internal/device/{device_id}/document/{document_id}', 'ServiceController@removeDeviceDocument');
    Route::delete('/internal/device/{device_id}/structured_data/{structured_data_id}', 'ServiceController@removeDeviceStructuredData');
});
