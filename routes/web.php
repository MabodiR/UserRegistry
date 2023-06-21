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

//user listing index
Route::get('/', 'UserListing@index')->name('user-listings');

Route::get('/user-listings', 'UserListing@index')->name('user-listings'); //user listing
Route::post('/user-listings/store', 'UserListing@store')->name('user-store');  //create user
Route::delete('/user-listings/destroy/{id}', 'UserListing@destroy')->name('user-destroy'); //delete user