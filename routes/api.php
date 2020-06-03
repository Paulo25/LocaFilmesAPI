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

Route::post('auth/login', 'Auth\AuthenticateController@login');

/*
ROTAS PROTEGIDAS COM JSON WEB TOKEN
USUÁRIO DEVE ESTAR LOGADO PARA ACESSAR ESSAS ROTAS
*/
Route::group(['middleware' => ['auth:api']], function () {

          //Rota de autenticação
          Route::group(['prefix' => 'auth'], function () {
                    Route::get('me', 'Auth\AuthenticateController@me');
                    Route::get('logout', 'Auth\AuthenticateController@logout');
                    Route::get('refresh', 'Auth\AuthenticateController@refresh');
                    Route::get('info-token/{token}', 'Auth\AuthenticateController@respondWithToken');
          });

          //Rota de clientes
          Route::group(['prefix' => 'clientes'], function () {
                    Route::apiResource('/', 'Api\ClienteController');
                    Route::get('{id}', 'Api\ClienteController@show')->name('cliente.show');
                    Route::get('{id}/documento', 'Api\ClienteController@documento')->name('cliente.documento');
                    Route::get('{id}/telefone', 'Api\ClienteController@telefone')->name('cliente.telefone');
                    Route::get('{id}/filme-alugado', 'Api\ClienteController@filmeAlugado')->name('cliente.filmeAlugado');
                    Route::get('completo/{id}', 'Api\ClienteController@clienteCompleto')->name('cliente.clienteCompleto');
          });

          //Rota de documentos do clientes
          Route::group(['prefix' => 'documentos'], function () {
                    Route::apiResource('/', 'Api\DocumentoController');
                    Route::get('{id}', 'Api\DocumentoController@show')->name('documentos.show');
                    Route::get('{id}/cliente', 'Api\DocumentoController@cliente')->name('documento.cliente');
          });

          //Rota de telefones do clientes
          Route::group(['prefix' => 'telefones'], function () {
                    Route::apiResource('/', 'Api\TelefoneController');
                    Route::get('{id}', 'Api\TelefoneController@show')->name('telefones.show');
                    Route::get('/{id}/cliente', 'Api\TelefoneController@cliente')->name('telefone.cliente');
          });

          //Rota de filmes
          Route::group(['prefix' => 'filmes'], function () {
                    Route::apiResource('/', 'Api\FilmeController');
                    Route::get('{id}', 'Api\FilmeController@show')->name('filmes.show');
          });
});













// Artisan::call('cache:clear');
// Artisan::call('config:clear');
// Artisan::call('config:cache');
// Artisan::call('view:clear');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
// O laravel-cors é um pacote permite enviar cabeçalhos de compartilhamento de recursos de origem cruzada com a configuração de middleware do Laravel.
