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
    return view('welcome');
});

Route::get('purple', function () {
    return view('themes.simple');
});
Route::get('/anuario/{serie_id_anuario}', 'AnuarioController@anuario_index')->name('anuarios.index');
Route::get('/anuario/personal/{serie_id_anuario}/{id_estudiante}', 'AnuarioController@personal_anuario')->name('anuarios_personal.index');
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/estudiantes/{id_anuario}', 'AnuarioController@estudiantes_anuario')->name('estudiantes.index');
    Route::get('/lista/estudiantes/{id_anuario}', 'EstudianteController@estudiantes_create')->name('exel');
    Route::post('/lista/save/{id_anuario}', 'EstudianteController@gestionar_excel')->name('post.exel');
    

    Route::get('/publicaciones/{id_anuario}', 'PublicacionesController@publicaciones_anuario')->name('publicaciones.index');
    Route::get('/publicaciones_create/{id_anuario}', 'PublicacionesController@publicaciones_create')->name('publicaciones.create');
    Route::post('/publicaciones/save/{id_anuario}', 'PublicacionesController@crear_publicacion')->name('post.publicacion');
    

    
});
