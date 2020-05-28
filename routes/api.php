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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('documentos', 'Api\DocumentoController');
Route::apiResource('clientes', 'Api\ClienteController');

Route::get('clientes/{id}/documento', 'Api\ClienteController@documento');
Route::get('documentos/{id}/cliente', 'Api\DocumentoController@cliente');
