<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(TestUserSeeder::class);
        $this->call(MateriasSeeder::class);
        $this->call(UnidadesSeeder::class);
    }
}
