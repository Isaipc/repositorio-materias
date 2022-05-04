<?php

use Illuminate\Support\Facades\Route;
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

Auth::routes();
Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => ['role:Alumno|Administrador']], function () {
        Route::get('/inicio', 'HomeController@index')->name('home');
        Route::get('/', 'HomeController@index');

        Route::get('materias/{materia}/archivos', 'ArchivoController@index')->name('archivos.index');

        Route::get('unidades/{materia}/list', 'UnidadController@list');
    });

    Route::group(['middleware' => ['role:Administrador']], function () {
        Route::get('usuarios', 'UsuarioController@index')->name('usuarios.index');
        Route::get('usuarios/list', 'UsuarioController@list');
        Route::get('usuarios/eliminados', 'UsuarioController@trash')->name('usuarios.trash');
        Route::get('usuarios/trash/list', 'UsuarioController@trashList');
        Route::put('usuarios/{user}/restaurar', 'UsuarioController@restore')->name('usuarios.restore');
        Route::get('usuarios/{user}/restablecer-contrasena', 'UsuarioController@editPassword')->name('usuarios.password-edit');
        Route::put('usuarios/{user}/contrasena/restablecer', 'UsuarioController@resetPassword')->name('usuarios.password-reset');
        Route::get('usuarios/nuevo', 'UsuarioController@new')->name('usuarios.create');
        Route::post('usuarios', 'UsuarioController@register')->name('usuarios.store');
        Route::get('usuarios/{user}', 'UsuarioController@show')->name('usuarios.show');
        Route::get('usuarios/{user}/editar', 'UsuarioController@edit')->name('usuarios.edit');
        Route::put('usuarios/{user}', 'UsuarioController@update')->name('usuarios.update');
        Route::delete('usuarios/{id}', 'UsuarioController@destroy')->name('usuarios.destroy');

        Route::get('materias', 'MateriaController@index')->name('materias.index');
        Route::get('materias/list', 'MateriaController@list');
        Route::get('materias/eliminados', 'MateriaController@trash')->name('materias.trash');
        Route::get('materias/trash/list', 'MateriaController@trashList');
        Route::get('materias/list', 'MateriaController@list')->name('materias.list');
        Route::put('materias/{materia}/restaurar', 'MateriaController@restore')->name('materias.restore');
        Route::get('materias/nuevo', 'MateriaController@create')->name('materias.create');
        Route::post('materias', 'MateriaController@store')->name('materias.store');
        Route::get('materias/{materia}', 'MateriaController@show')->name('materias.show');
        Route::get('materias/{materia}/editar', 'MateriaController@edit')->name('materias.edit');
        Route::put('materias/{materia}', 'MateriaController@update')->name('materias.update');
        Route::put('materias/{materia}/change-status', 'MateriaController@changeStatus');
        Route::delete('materias/{materia}/archive', 'MateriaController@archive');
        Route::delete('materias/{materia}', 'MateriaController@destroy')->name('materias.destroy');

        Route::get('materias/{materia}/alumnos', 'AlumnoController@index')->name('alumnos.index');

        Route::get('alumnos/{materia}/list', 'AlumnoController@list');

        Route::get('unidades/eliminados', 'UnidadController@trash')->name('unidades.trash');
        Route::get('unidades/trash/list', 'UnidadController@trashList');
        Route::put('unidades/{unidad}/restaurar', 'UnidadController@restore')->name('unidades.restore');
        Route::post('unidades', 'UnidadController@store')->name('unidades.store');
        Route::get('unidades/{unidad}', 'UnidadController@show')->name('unidades.show');
        Route::put('unidades/{unidad}', 'UnidadController@update')->name('unidades.update');
        Route::delete('unidades/{unidad}', 'UnidadController@destroy')->name('unidades.destroy');


        Route::get('archivos/{unidad}/list', 'ArchivoController@list');
        Route::post('archivos/{unidad}', 'ArchivoController@store');

        Route::get('materias/{materia}/archivos/eliminados', 'ArchivoController@trash')->name('archivos.trash');
        Route::put('materias/archivos/{archivo}/restaurar', 'ArchivoController@restore')->name('archivos.restore');
        Route::get('materias/{materia}/archivos/nuevo', 'ArchivoController@create')->name('archivos.create');
        Route::post('materias/{materia}/archivos', 'ArchivoController@store')->name('archivos.store');
        Route::get('materias/{materia}/archivos/{archivo}', 'ArchivoController@show')->name('archivos.show');
    });
});
