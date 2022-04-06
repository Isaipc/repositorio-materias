<?php

use App\Materia;
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
        Materia::create(['nombre' => 'Fundamento de Telecomunicaciones', 'estatus' => 1]);
        Materia::create(['nombre' => 'Redes de Computadoras', 'estatus' => 1]);
        Materia::create(['nombre' => 'Administración de Redes', 'estatus' => 1]);
    }
}
