<?php

use App\Job;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/job','JobController@store')->name('job');

Route::post('/apply/{id}','CandidateController@store')->name('jobs.apply');

Route::post('/cancel/{id}','CandidateController@destroy')->name('jobs.cancel');

Route::post('/view/{id}','JobController@show')->name('jobs.applicants');

Route::get('/sendAppliedMail/{id}','MailController@applied_mail')->name('mail.send');

Route::post('/company','Auth\RegisterController@company')->name('comapnies.add');

Route::post('/job/{id}','JobController@update')->name('jobs.update');

Route::post('/deletejob/{id}','JobController@destroy')->name('jobs.delete');