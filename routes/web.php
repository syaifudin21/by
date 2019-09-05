<?php

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
    return "loading...";
});

Route::get('/tagihan', 'TagihanController@home')->name('tagihan.home');
Route::post('/tagihan', 'TagihanController@store')->name('tagihan.store');
Route::get('/tagihan/lunasi', 'TagihanController@lunasi')->name('tagihan.lunasi');
Route::get('/tagihan/status', 'TagihanController@status')->name('tagihan.status');
Route::get('/tagihan/reversal', 'TagihanController@reversal')->name('tagihan.reversal');
Route::get('/tagihan/enabled', 'SoapController@enabled')->name('tagihan.enabled');
// Route::get('/tagihan/enabled', 'TagihanController@enabled')->name('tagihan.enabled');
Route::get('/tagihan/disabled', 'TagihanController@disabled')->name('tagihan.disabled');
Route::get('/tagihan/delete', 'TagihanController@delete')->name('tagihan.delete');
Route::get('/success', 'TagihanController@success')->name('success');

Route::get('/error', function () {
    dd($_GET);
})->name('error');
