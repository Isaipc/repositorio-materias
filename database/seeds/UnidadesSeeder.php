<?php

use App\Materia;
use App\Unidad;
use Illuminate\Database\Seeder;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i < 5; $i++) {
            $materia = Materia::find(1);
            $unidad = new Unidad(['nombre' => "Unidad $i $materia->nombre", 'estatus' => 1]);
            $materia->unidades()->save($unidad);

            $materia = Materia::find(2);
            $unidad = new Unidad(['nombre' => "Unidad $i $materia->nombre", 'estatus' => 1]);
            $materia->unidades()->save($unidad);

            $materia = Materia::find(3);
            $unidad = new Unidad(['nombre' => "Unidad $i $materia->nombre", 'estatus' => 1]);
            $materia->unidades()->save($unidad);
        }
    }
}
