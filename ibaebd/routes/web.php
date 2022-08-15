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

Route::get('/ebd', function () { return view('ebd_discipuladora'); });

Route::get('/manha_divertida', function () { return view('manha_divertida'); });

Route::get('/socasais', function () { return view('casais'); });

Route::get('/cafe_comunhao', function () { return view('cafeComunhao'); });

Route::get('/ebd_musicos', function () { return view('ebdMusicos'); });

Auth::routes();

Route::post('/atualizar','MatriculaController@atualizar');
Route::post('/inscricaoManhaDivertida/atualizar','InscricaoManhaDivertidaController@atualizar');
Route::post('/casais/atualizar','CasalController@atualizar');
Route::post('/cafeComunhao/atualizar','CafeComunhaoController@store');
Route::post('/ebdMusicos/atualizar','EbdMusicosController@atualizar');

Route::group(['middleware'=>'auth'],function(){
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
    Route::get('/getMatriculas','MatriculaController@getMatriculas')->middleware('verified');
    Route::delete('/deletar/{id}','MatriculaController@deletar');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/inscricaoManhaDivertida','InscricaoManhaDivertidaController@getInscricoesManhaDivertida')->middleware('verified');
    Route::delete('/inscricaoManhaDivertida/deletar/{id}','InscricaoManhaDivertidaController@deletar');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/esposa','EsposaController@getEsposas')->middleware('verified');
    Route::delete('/esposa/deletar/{id}','EsposaController@deletar');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/esposo','EsposoController@getEsposos')->middleware('verified');
    Route::delete('/esposo/deletar/{id}','EsposoController@deletar');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/casais','CasalController@getCasais')->middleware('verified');
    Route::delete('/casais/deletar/{id}','CasalController@deletar');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/cafeComunhao','CafeComunhaoController@getCafeComunhaos')->middleware('verified');
    Route::delete('/cafeComunhao/deletar/{id}','CafeComunhaoController@deletar');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/ebdMusicos','EbdMusicosController@getEbdMusicos')->middleware('verified');
    Route::delete('/ebdMusicos/deletar/{id}','EbdMusicosController@deletar');
});
