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

Auth::routes(['verify' => true]);
Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => ['role:Alumno|Administrador']], function () {
        Route::get('/', 'HomeController@index')->name('home');

        Route::middleware(['alumno_en_materia'])->group(function () {
            Route::get('materias/{materia}/contenido', 'ArchivoController@index')->name('archivos.index');
            Route::get('unidades-ajax/{materia}', 'UnidadAJAXController@index');
        });

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

        Route::prefix('materias-ajax')->group(function () {
            Route::get('', 'MateriaAJAXController@index');
            Route::get('trash', 'MateriaAJAXController@trash');
            Route::post('', 'MateriaAJAXController@store');
            Route::put('{materia}', 'MateriaAJAXController@update');
            Route::put('{materia}/change-status', 'MateriaAJAXController@changeStatus');
            Route::delete('{materia}/archive', 'MateriaAJAXController@archive');
            Route::put('{materia}/restore', 'MateriaAJAXController@restore');
            Route::delete('{materia}', 'MateriaAJAXController@destroy');
        });

        Route::prefix('materias')->group(function () {
            Route::get('', 'MateriaController@index')->name('materias.index');
            Route::get('eliminados', 'MateriaController@trash')->name('materias.trash');
            Route::get('{materia}', 'MateriaController@show')->name('materias.show');
        });

        Route::get('materias/{materia}/alumnos', 'AlumnoController@index')->name('alumnos.index');
        Route::get('alumnos/{materia}/list', 'AlumnoController@list');

        Route::prefix('archivos')->group(function () {
            Route::get('{unidad}/list', 'ArchivoController@list');
            Route::post('{unidad}', 'ArchivoController@store');
        });

        Route::prefix('unidades')->group(function () {
            // Route::get('', 'UnidadAJAXController@index')->name('unidades.index');
            // Route::get('eliminados', 'UnidadAJAXController@trash')->name('unidades.trash');
            Route::get('{unidad}', 'UnidadController@show');
        });
        Route::prefix('unidades-ajax')->group(function () {
            Route::get('{materia}/trash', 'UnidadAJAXController@trash');
            Route::post('', 'UnidadAJAXController@store');
            Route::put('{unidad}', 'UnidadAJAXController@update');
            Route::delete('{unidad}/archive', 'UnidadAJAXController@archive');
            Route::put('{unidad}/restore', 'UnidadAJAXController@restore');
            Route::delete('{unidad}', 'UnidadAJAXController@destroy');
        });

        Route::get('materias/{materia}/contenido/eliminados', 'ArchivoController@trash')->name('archivos.trash');
        Route::get('unidades/{materia}/trash/list', 'UnidadController@trashList');
    });
});
