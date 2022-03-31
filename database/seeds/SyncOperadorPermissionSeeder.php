<?php

use Illuminate\Database\Seeder;
use App\Operador;

class SyncOperadorPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Operador::all() as $key => $operador)
            if ($operador->user)
                $operador->user->syncRoles('Operador');
    }
}
