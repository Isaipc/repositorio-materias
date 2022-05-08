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

        Route::middleware(['alumno_en_materia'])->group(function () {
            Route::get('materias/{materia}/archivos', 'ArchivoController@index')->name('archivos.index');
        });

        Route::get('unidades/{materia}/list', 'UnidadController@list');
        Route::post('alumnos/materias', 'AlumnoEnMateriaController@store');
        Route::get('alumnos/materias', 'AlumnoEnMateriaController@index');
        Route::delete('alumnos/materias/{materia}', 'AlumnoEnMateriaController@destroy');
    });

    Route::group(['middleware' => ['role:Administrador']], function () {
        Route::prefix('usuarios')->group(function () {
            Route::get('', 'UsuarioController@index')->name('usuarios.index');
            Route::get('list', 'UsuarioController@list');
            Route::get('eliminados', 'UsuarioController@trash')->name('usuarios.trash');
            Route::get('trash/list', 'UsuarioController@trashList');
            Route::put('{user}/restaurar', 'UsuarioController@restore')->name('usuarios.restore');
            Route::get('{user}/restablecer-contrasena', 'UsuarioController@editPassword')->name('usuarios.password-edit');
            Route::put('{user}/contrasena/restablecer', 'UsuarioController@resetPassword')->name('usuarios.password-reset');
            Route::get('nuevo', 'UsuarioController@new')->name('usuarios.create');
            Route::post('', 'UsuarioController@register')->name('usuarios.store');
            Route::get('{user}', 'UsuarioController@show')->name('usuarios.show');
            Route::get('{user}/editar', 'UsuarioController@edit')->name('usuarios.edit');
            Route::put('{user}', 'UsuarioController@update')->name('usuarios.update');
            Route::delete('{user}/archive', 'UsuarioController@archive');
            Route::delete('{user}', 'UsuarioController@destroy')->name('usuarios.destroy');
        });

        Route::prefix('materias')->group(function () {
            Route::get('', 'MateriaController@index')->name('materias.index');
            Route::get('list', 'MateriaController@list');
            Route::get('eliminados', 'MateriaController@trash')->name('materias.trash');
            Route::get('trash/list', 'MateriaController@trashList');
            Route::get('list', 'MateriaController@list')->name('materias.list');
            Route::put('{materia}/restaurar', 'MateriaController@restore')->name('materias.restore');
            Route::get('nuevo', 'MateriaController@create')->name('materias.create');
            Route::post('', 'MateriaController@store')->name('materias.store');
            Route::get('{materia}', 'MateriaController@show')->name('materias.show');
            Route::get('{materia}/editar', 'MateriaController@edit')->name('materias.edit');
            Route::put('{materia}', 'MateriaController@update')->name('materias.update');
            Route::put('{materia}/change-status', 'MateriaController@changeStatus');
            Route::delete('{materia}/archive', 'MateriaController@archive');
            Route::delete('{materia}', 'MateriaController@destroy')->name('materias.destroy');
        });

        Route::get('materias/{materia}/alumnos', 'AlumnoController@index')->name('alumnos.index');
        Route::get('alumnos/{materia}/list', 'AlumnoController@list');

        Route::prefix('archivos')->group(function () {
            Route::get('{unidad}/list', 'ArchivoController@list');
            Route::post('{unidad}', 'ArchivoController@store');
        });

        Route::prefix('unidades')->group(function () {
            Route::get('eliminados', 'UnidadController@trash')->name('unidades.trash');
            Route::get('trash/list', 'UnidadController@trashList');
            Route::put('{unidad}/restaurar', 'UnidadController@restore')->name('unidades.restore');
            Route::post('', 'UnidadController@store')->name('unidades.store');
            Route::get('{unidad}', 'UnidadController@show')->name('unidades.show');
            Route::put('{unidad}', 'UnidadController@update')->name('unidades.update');
            Route::delete('{unidad}', 'UnidadController@destroy')->name('unidades.destroy');
        });
    });
});
