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
        $trail->push($model->alias(), route("$name.show", $model));
    });

    // Home > Blog > Post 123 > Edit
    Breadcrumbs::for("$name.edit", function ($trail, $model) use ($name) {
        $trail->parent("$name.show", $model);
        $trail->push('Editar', route("$name.edit", $model));
    });
});

Breadcrumbs::resource('home', 'usuarios', 'Usuarios');
Breadcrumbs::resource('home', 'operadores', 'Operadores');
Breadcrumbs::resource('home', 'documentos', 'Documentos');
Breadcrumbs::resource('home', 'materias', 'Materias');
Breadcrumbs::resource('home', 'puntos-de-revision', 'Puntos de revisión');
Breadcrumbs::resource('home', 'roles', 'Roles');
Breadcrumbs::resource('home', 'permisos', 'Permisos');

// // Home > Blog > Post 123
// Breadcrumbs::for("roles.show", function ($trail, Role $model) {
//     $trail->parent("roles.index");
//     $trail->push($model->alias(), route("roles.show", $model));
// });

// // Home > Blog > Post 123 > Edit
// Breadcrumbs::for("roles.edit", function ($trail, $model) {
//     $trail->parent("roles.show", $model);
//     $trail->push('Editar', route("roles.edit", $model));
// });

// Home > Blog > Post 123
Breadcrumbs::for("usuarios.password-edit", function ($trail, App\User $user) {
    $trail->parent("usuarios.show", $user);
    $trail->push('Restablecer contraseña', route("usuarios.password-edit", $user));
});


// // Principal 
// Breadcrumbs::for("tienda.index", function ($trail) {
//     $trail->push('Materiales', route("tienda.index"));
// });

// // Principal > ver > Producto 123
// Breadcrumbs::for("tienda.producto", function ($trail, $model) {
//     $trail->parent('tienda.index');
//     $trail->push($model->alias(), route("tienda.producto", $model));
// });

// // Principal > Carrito 
// Breadcrumbs::for("carrito.index", function ($trail) {
//     $trail->parent('tienda.index');
//     $trail->push('Carrito de compras', route("carrito.index"));
// });

// // Realizar pedido 
// Breadcrumbs::for("", function ($trail) {
//     $trail->parent('tienda.index');
//     $trail->push('Carrito de compras', route("carrito.index"));
// });

// // Realizar pedido > Metodo de pago
// Breadcrumbs::for("pagos.index", function ($trail) {
//     $trail->parent('carrito.index');
//     $trail->push('Elegir método de pago', route("pagos.index"));
// });

// // Principal > Carrito > Metodo de pago > Pagar 
// Breadcrumbs::for("pagos.create", function ($trail) {
//     $trail->parent('pagos.index');
//     $trail->push('Pagar', route("pagos.create"));
// });

// // Principal > Carrito > Completado
// Breadcrumbs::for("pagos.completado", function ($trail) {
//     $trail->parent('pagos.create');
//     $trail->push('Compra completada', route("pagos.completado"));
// });

// // Realizar pedido > Metodo de pago > Pagar en OXXO
// Breadcrumbs::for("pagos.create.oxxo", function ($trail) {
//     $trail->parent('pagos.index');
//     $trail->push('Pagar en OXXO', route("pagos.create.oxxo"));
// });

// // Realizar pedido > Metodo de pago > Pagar con tarjeta
// Breadcrumbs::for("pagos.create.tarjeta", function ($trail) {
//     $trail->parent('pagos.index');
//     $trail->push('Pagar con tarjeta', route("pagos.create.tarjeta"));
// });
