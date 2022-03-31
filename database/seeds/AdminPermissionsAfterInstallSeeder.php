<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminPermissionsAfterInstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::where('name', 'Administrador')->first();
        $user->syncRoles(['Administrador', 'Operador']);
    }
}
