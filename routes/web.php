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
    Route::get('/bienvenida', function () {
        return view('bienvenida');
    })->name('welcome');
    Route::get('/inicio', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index');

    Route::get('roles', 'RoleController@index')->name('roles.index');
    Route::get('roles/eliminados', 'RoleController@trash')->name('roles.trash');
    Route::get('roles/nuevo', 'RoleController@create')->name('roles.create');
    Route::get('roles/eliminados', 'RoleController@trash')->name('roles.trash');
    Route::put('roles/{role}/restaurar', 'RoleController@restore')->name('roles.restore');
    Route::get('roles/nuevo', 'RoleController@create')->name('roles.create');
    Route::post('roles', 'RoleController@store')->name('roles.store');
    Route::get('roles/{role}', 'RoleController@show')->name('roles.show');
    Route::get('roles/{role}/editar', 'RoleController@edit')->name('roles.edit');
    Route::put('roles/{role}', 'RoleController@update')->name('roles.update');
    Route::delete('roles/{role}', 'RoleController@destroy')->name('roles.destroy');

    Route::get('permisos', 'PermissionController@index')->name('permisos.index');
    Route::get('permisos/eliminados', 'PermissionController@trash')->name('permisos.trash');
    Route::get('permisos/nuevo', 'PermissionController@create')->name('permisos.create');
    Route::get('permisos/eliminados', 'PermissionController@trash')->name('permisos.trash');
    Route::put('permisos/{permiso}/restaurar', 'PermissionController@restore')->name('permisos.restore');
    Route::get('permisos/nuevo', 'PermissionController@create')->name('permisos.create');
    Route::post('permisos', 'PermissionController@store')->name('permisos.store');
    Route::get('permisos/{permiso}', 'PermissionController@show')->name('permisos.show');
    Route::get('permisos/{permiso}/editar', 'PermissionController@edit')->name('permisos.edit');
    Route::put('permisos/{permiso}', 'PermissionController@update')->name('permisos.update');
    Route::delete('permisos/{permiso}', 'PermissionController@destroy')->name('permisos.destroy');

    Route::get('usuarios', 'UsuarioController@index')->name('usuarios.index');
    Route::get('usuarios/eliminados', 'UsuarioController@trash')->name('usuarios.trash');
    Route::put('usuarios/{user}/restaurar', 'UsuarioController@restore')->name('usuarios.restore');
    Route::get('usuarios/{user}/restablecer-contrasena', 'UsuarioController@editPassword')->name('usuarios.password-edit');
    Route::put('usuarios/{user}/contrasena/restablecer', 'UsuarioController@resetPassword')->name('usuarios.password-reset');
    Route::get('usuarios/nuevo', 'UsuarioController@new')->name('usuarios.create');
    Route::post('usuarios', 'UsuarioController@register')->name('usuarios.store');
    Route::get('usuarios/{user}', 'UsuarioController@show')->name('usuarios.show');
    Route::get('usuarios/{user}/editar', 'UsuarioController@edit')->name('usuarios.edit');
    Route::put('usuarios/{user}', 'UsuarioController@update')->name('usuarios.update');
    Route::delete('usuarios/{user}', 'UsuarioController@destroy')->name('usuarios.destroy');

    Route::get('materias', 'MateriaController@index')->name('materias.index');
    Route::get('materias/eliminados', 'MateriaController@trash')->name('materias.trash');
    Route::put('materias/{materia}/restaurar', 'MateriaController@restore')->name('materias.restore');
    Route::get('materias/nuevo', 'MateriaController@create')->name('materias.create');
    Route::post('materias', 'MateriaController@store')->name('materias.store');
    Route::get('materias/{materia}', 'MateriaController@show')->name('materias.show');
    Route::get('materias/{materia}/editar', 'MateriaController@edit')->name('materias.edit');
    Route::put('materias/{materia}', 'MateriaController@update')->name('materias.update');
    Route::delete('materias/{materia}', 'MateriaController@destroy')->name('materias.destroy');

    Route::get('materias/{materia}/archivos', 'ArchivoController@index')->name('archivos.index');
    Route::get('materias/{materia}/archivos/eliminados', 'ArchivoController@trash')->name('archivos.trash');
    Route::put('materias/archivos/{archivo}/restaurar', 'ArchivoController@restore')->name('archivos.restore');
    Route::get('materias/{materia}/archivos/nuevo', 'ArchivoController@create')->name('archivos.create');
    Route::post('materias/{materia}/archivos', 'ArchivoController@store')->name('archivos.store');
    Route::get('materias/{materia}/archivos/{archivo}', 'ArchivoController@show')->name('archivos.show');
    Route::get('materias/{materia}/archivos/{archivo}/editar', 'ArchivoController@edit')->name('archivos.edit');
    Route::put('materias/archivos/{archivo}', 'ArchivoController@update')->name('archivos.update');
    Route::delete('materias/archivos/{archivo}/archive', 'ArchivoController@archive')->name('archivos.archive');
    Route::delete('materias/archivos/{archivo}/delete', 'ArchivoController@destroy')->name('archivos.destroy');
});
