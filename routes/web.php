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
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::group(['middleware' => ['role:Alumno|Administrador']], function () {
        Route::get('/', 'HomeController@index')->name('home');

        Route::middleware(['alumno_en_materia'])->group(function () {
            Route::get('materias/{materia}/unidades', 'UnidadController@index')->name('unidades.index');
            Route::get('unidades-ajax/{materia}', 'UnidadAJAXController@index');
        });

        Route::prefix('claves-materia')->group(function () {
            Route::post('', 'ClaveMateriaController@store')->name('claves-materia.store');
            Route::delete('{materia}', 'ClaveMateriaController@destroy')->name('claves-materia.destroy');
        });

        Route::get('archivos/{archivo}/{nombre}', 'ArchivoController@show')->name('archivos.show');
    });

    Route::group(['middleware' => ['role:Administrador']], function () {
        Route::prefix('usuarios')->group(function () {
            Route::get('', 'UsuarioController@index')->name('usuarios.index');
            Route::get('list', 'UsuarioController@list');
            Route::get('eliminados', 'UsuarioController@trash')->name('usuarios.trash');
            Route::put('{user}/restore', 'UsuarioController@restore')->name('usuarios.restore');
            Route::get('{user}/restablecer-contrasena', 'UsuarioController@editPassword')->name('usuarios.password-edit');
            Route::get('trash/list', 'UsuarioController@trashList');
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
            Route::get('{materia}/editar', 'MateriaController@edit')->name('materias.edit');
            Route::get('{materia}/alumnos', 'AlumnosEnMateriaController@index')->name('alumnos.index');
            Route::get('{materia}/unidades/eliminados', 'UnidadController@trash')->name('unidades.trash');
        });
        Route::get('alumnos-en-materia/{materia}', 'AlumnosEnMateriaAJAXController@index');
        Route::delete('alumnos-en-materia/{alumnoEnMateria}', 'AlumnosEnMateriaAJAXController@destroy');
        Route::delete('alumnos-en-materia/close-course/{materia}', 'AlumnosEnMateriaAJAXController@closeCourse');

        Route::prefix('archivos')->group(function () {
            Route::get('{unidad}', 'ArchivoController@index')->name('archivos.index');
        });

        Route::prefix('archivos-ajax')->group(function () {
            Route::get('{unidad}', 'ArchivoAJAXController@index');
            Route::get('{unidad}/trash', 'ArchivoAJAXController@trash');
            Route::post('', 'ArchivoAJAXController@store');
            Route::put('{archivo}', 'ArchivoAJAXController@update');
            Route::put('{archivo}/change-status', 'ArchivoAJAXController@changeStatus');
            Route::delete('{archivo}/archive', 'ArchivoAJAXController@archive');
            Route::put('{archivo}/restore', 'ArchivoAJAXController@restore');
            Route::delete('{archivo}', 'ArchivoAJAXController@destroy');
        });

        Route::prefix('unidades')->group(function () {
            Route::get('{unidad}', 'UnidadController@show');
            Route::get('{unidad}/archivos/eliminados', 'ArchivoController@trash')->name('archivos.trash');
        });
        Route::prefix('unidades-ajax')->group(function () {
            Route::get('{materia}/trash', 'UnidadAJAXController@trash');
            Route::post('', 'UnidadAJAXController@store');
            Route::put('{unidad}', 'UnidadAJAXController@update');
            Route::put('{unidad}/change-status', 'UnidadAJAXController@changeStatus');
            Route::delete('{unidad}/archive', 'UnidadAJAXController@archive');
            Route::put('{unidad}/restore', 'UnidadAJAXController@restore');
            Route::delete('{unidad}', 'UnidadAJAXController@destroy');
        });

        Route::get('unidades/{materia}/trash/list', 'UnidadController@trashList');
    });
});
