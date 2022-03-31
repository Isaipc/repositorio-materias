<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alumn_permissions = [
            ['name' => 'home'],
        ];

        $admin_permissions = [
            ['name' => 'panel-de-control'],
            ['name' => 'roles-lista'],
            ['name' => 'roles-eliminados'],
            ['name' => 'roles-nuevo'],
            ['name' => 'roles-restaurar'],
            ['name' => 'roles-guardar'],
            ['name' => 'roles-mostrar'],
            ['name' => 'roles-editar'],
            ['name' => 'roles-actualizar'],
            ['name' => 'roles-eliminar'],

            ['name' => 'permisos-lista'],
            ['name' => 'permisos-eliminados'],
            ['name' => 'permisos-nuevo'],
            ['name' => 'permisos-editar'],
            ['name' => 'permisos-guardar'],
            ['name' => 'permisos-actualizar'],
            ['name' => 'permisos-eliminar'],
            ['name' => 'permisos-restaurar'],
            ['name' => 'permisos-mostrar'],

            ['name' => 'documentos-lista'],
            ['name' => 'documentos-eliminados'],
            ['name' => 'documentos-nuevo'],
            ['name' => 'documentos-editar'],
            ['name' => 'documentos-guardar'],
            ['name' => 'documentos-actualizar'],
            ['name' => 'documentos-eliminar'],
            ['name' => 'documentos-restaurar'],
            ['name' => 'documentos-mostrar'],

            ['name' => 'materias-lista'],
            ['name' => 'materias-eliminados'],
            ['name' => 'materias-nuevo'],
            ['name' => 'materias-editar'],
            ['name' => 'materias-guardar'],
            ['name' => 'materias-actualizar'],
            ['name' => 'materias-eliminar'],
            ['name' => 'materias-restaurar'],
            ['name' => 'materias-mostrar'],

            ['name' => 'usuarios-lista'],
            ['name' => 'usuarios-eliminados'],
            ['name' => 'usuarios-nuevo'],
            ['name' => 'usuarios-editar'],
            ['name' => 'usuarios-guardar'],
            ['name' => 'usuarios-actualizar'],
            ['name' => 'usuarios-eliminar'],
            ['name' => 'usuarios-mostrar'],
        ];

        foreach ($admin_permissions as $key => $p) {
            Permission::create($p);
        }

        foreach ($alumn_permissions as $key => $p) {
            Permission::create($p);
        }

        $admin = Role::create(['name' => 'Administrador']);
        $alumn = Role::create(['name' => 'Alumno']);

        // $admin->givePermissionTo($admin_permissions);
        $alumn->givePermissionTo($alumn_permissions);
    }
}
