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
        Materia::create(['nombre' => 'Fundamento de Telecomunicaciones']);
        Materia::create(['nombre' => 'Redes de Computadoras']);
        Materia::create(['nombre' => 'Administración de Redes']);
    }
}
