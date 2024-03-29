<?php

use App\Producto;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Spatie\Permission\Models\Role;

// Home 
Breadcrumbs::for("home", function ($trail) {
    $trail->push('Repositorio', route("home"));
});

Breadcrumbs::macro('resource', function ($parent, $name, $title) {
    // Home > Blog
    Breadcrumbs::for("$name.index", function ($trail) use ($parent, $name, $title) {
        $trail->parent($parent);
        $trail->push($title, route("$name.index"));
    });

    // Home > Blog > New
    Breadcrumbs::for("$name.trash", function ($trail) use ($name) {
        $trail->parent("$name.index");
        $trail->push('Eliminados', route("$name.trash"));
    });

    // Home > Blog > New
    Breadcrumbs::for("$name.create", function ($trail) use ($name) {
        $trail->parent("$name.index");
        $trail->push('Nuevo', route("$name.create"));
    });

    // Home > Blog > Post 123
    Breadcrumbs::for("$name.show", function ($trail, $model) use ($name) {
        $trail->parent("$name.index");
        $trail->push($model->nombre, route("$name.show", $model));
    });

    // Home > Blog > Post 123 > Edit
    Breadcrumbs::for("$name.edit", function ($trail, $model) use ($name) {
        $trail->parent("$name.show", $model);
        $trail->push('Editar', route("$name.edit", $model));
    });
});

Breadcrumbs::resource('home', 'usuarios', 'Alumnos');
Breadcrumbs::resource('home', 'materias', 'Materias');

Breadcrumbs::for("unidades.index", function ($trail, $model) {
    $trail->parent('materias.show', $model);
    $trail->push('Contenido', route('unidades.index', $model));
});

Breadcrumbs::for("alumnos.index", function ($trail, $model) {
    $trail->parent('materias.show', $model);
    $trail->push('Alumnos', route('alumnos.index', $model));
});

Breadcrumbs::for("unidades.trash", function ($trail, $model) {
    $trail->parent('unidades.index', $model);
    $trail->push('Unidades eliminadas', route('unidades.trash', $model));
});

Breadcrumbs::for("archivos.index", function ($trail, $parentModel, $model) {
    $trail->parent('unidades.index', $parentModel, $model);
    $trail->push($model->nombre, route('archivos.index', [$parentModel, $model]));
});

Breadcrumbs::for("archivos.trash", function ($trail, $parentModel, $model) {
    $trail->parent('archivos.index', $parentModel, $model);
    $trail->push('Archivos eliminados', route('archivos.trash', [$parentModel, $model]));
});

// Home > Blog > Post 123
Breadcrumbs::for("usuarios.password-edit", function ($trail, App\User $user) {
    $trail->parent("usuarios.show", $user);
    $trail->push('Restablecer contraseña', route("usuarios.password-edit", $user));
});
