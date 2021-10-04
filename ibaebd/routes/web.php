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

Route::get('/', function () {
    return view('home');
});

Route::get('/ebd', function () {
    return view('ebd_discipuladora');
});

Route::get('/manha_divertida', function () {
    return view('manha_divertida');
});

Auth::routes();

Route::post('/atualizar','MatriculaController@atualizar');
Route::post('/inscricaoManhaDivertida/atualizar','InscricaoManhaDivertidaController@atualizar');

Route::group(['middleware'=>'auth'],function(){
    Route::get('/getMatriculas','MatriculaController@getMatriculas')->middleware('verified');
    Route::delete('/deletar/{id}','MatriculaController@deletar');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/inscricaoManhaDivertida','InscricaoManhaDivertidaController@getInscricoesManhaDivertida')->middleware('verified');
    Route::delete('/inscricaoManhaDivertida/deletar/{id}','InscricaoManhaDivertidaController@deletar');
});