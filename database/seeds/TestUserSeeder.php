<?php

use App\AlumnoEnMateria;
use App\User;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->fill([
            'nombre' => 'Gustavo Eslava',
            'username' => 'gustavo01',
            'email' => 'gustavo.eslava@itssat.edu.mx',
            'password' => bcrypt('12345678'),
        ])->save();
        $user->assignRole('Alumno');

        AlumnoEnMateria::create(['usuario_id' => $user->id, 'materia_id' => 1]);
        AlumnoEnMateria::create(['usuario_id' => $user->id, 'materia_id' => 2]);

        $user = new User;
        $user->fill([
            'nombre' => 'Hector David Ortiz Mateo',
            'username' => 'hector_ortiz',
            'email' => 'hector.ortiz@itssat.edu.mx',
            'password' => bcrypt('12345678'),
        ])->save();
        $user->assignRole('Alumno');

        AlumnoEnMateria::create(['usuario_id' => $user->id, 'materia_id' => 1]);



        $user = new User;
        $user->fill([
            'nombre' => 'Alumno test',
            'username' => 'test',
            'email' => 'alumno@itssat.edu.mx',
            'password' => bcrypt('12345678')
        ])->save();
        $user->assignRole('Alumno');

        AlumnoEnMateria::create(['usuario_id' => $user->id, 'materia_id' => 1]);
        AlumnoEnMateria::create(['usuario_id' => $user->id, 'materia_id' => 3]);

        $user = new User;
        $user->fill([
            'nombre' => 'Alumno test 2',
            'username' => 'test2',
            'email' => 'alumno2@itssat.edu.mx',
            'password' => bcrypt('12345678')
        ])->save();
        $user->assignRole('Alumno');

        AlumnoEnMateria::create(['usuario_id' => $user->id, 'materia_id' => 3]);
    }
}
