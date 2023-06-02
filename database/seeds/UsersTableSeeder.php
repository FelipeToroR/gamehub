<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'      => 'Super administrador',
            'email'     => 'admin@pucv.cl',
            'password'     => bcrypt('admin123'),

        ]);

        App\User::create([
            'name'      => 'Learner dummy',
            'email'     => 'learner@pucv.cl',
            'password'     => bcrypt('learner123'),

        ]);

    }
}
