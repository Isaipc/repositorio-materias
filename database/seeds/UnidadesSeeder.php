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

        $materia = Materia::find(1);
        $materia->unidades()->saveMany([
            new Unidad(['nombre' => "Unidad I. Fundamentos de telecomunicaciones", 'estatus' => 1]),
            new Unidad(['nombre' => "Unidad II. Medios de transmisión", 'estatus' => 1]),
            new Unidad(['nombre' => "Unidad III. Modulación", 'estatus' => 1]),
            new Unidad(['nombre' => "Unidad IV. Computación", 'estatus' => 1]),
        ]);

        $materia = Materia::find(2);
        $materia->unidades()->saveMany([
            new Unidad(['nombre' => "Unidad I. Aspectos básicos de redes", 'estatus' => 1]),
            new Unidad(['nombre' => "Unidad II. Nomras y estándares", 'estatus' => 1]),
            new Unidad(['nombre' => "Unidad III. Dispositivos de red", 'estatus' => 1]),
            new Unidad(['nombre' => "Unidad IV. Cableado estructurado", 'estatus' => 1]),
            new Unidad(['nombre' => "Unidad V. Planificación y diseño", 'estatus' => 1]),
        ]);

        for ($i = 1; $i < 5; $i++) {
            $materia = Materia::find(3);
            $unidad = new Unidad(['nombre' => "Unidad $i.", 'estatus' => 1]);
            $materia->unidades()->save($unidad);
        }
    }
}
