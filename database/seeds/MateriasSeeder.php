<?php

use App\Constants;
use App\Materia;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Materia::create([
            'nombre' => 'Fundamento de Telecomunicaciones',
            'estatus' => 1,
            'clave' => Str::random(config('constants.key_length'))
        ]);
        Materia::create([
            'nombre' => 'Redes de Computadoras',
            'estatus' => 1,
            'clave' => Str::random(config('constants.key_length'))
        ]);
        Materia::create([
            'nombre' => 'Administración de Redes',
            'estatus' => 1,
            'clave' => Str::random(config('constants.key_length'))
        ]);
    }
}
