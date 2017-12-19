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

// Home routes
Route::get('/', 'Frontend\WelcomeController@index')->name('frontend.index');

// Signature route
Route::post('/onderteken', 'Frontend\SignatureController@store')->name('signature.store');

// Disclaimer routes
Route::get('/disclaimer', 'Frontend\DisclaimerController@index')->name('disclaimer.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
