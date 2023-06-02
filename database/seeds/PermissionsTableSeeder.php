<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;


class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista de permisos

        Permission::create(['name' => 'games.index']);
        Permission::create(['name' => 'games.edit']);
        Permission::create(['name' => 'games.show']);
        Permission::create(['name' => 'games.create']);
        Permission::create(['name' => 'games.destroy']);
        Permission::create(['name' => 'game-instances.play']);
        Permission::create(['name' => 'game-instances.index']);
        Permission::create(['name' => 'game-instances.edit']);
        Permission::create(['name' => 'game-instances.show']);
        Permission::create(['name' => 'game-instances.create']);
        Permission::create(['name' => 'game-instances.destroy']);
        Permission::create(['name' => 'experiments.create']);


        //Admin
        $admin = Role::create(['name' => 'admin']);

        $admin->givePermissionTo([
            'games.index',
            'games.edit',
            'games.show',
            'games.create',
            'games.destroy',
            'game-instances.play',
            'game-instances.index',
            'game-instances.edit',
            'game-instances.show',
            'game-instances.create',
            'game-instances.destroy',
            'game-instances.destroy',
            'experiments.create'
            ]);

        //$admin->givePermissionTo('products.index');
        //$admin->givePermissionTo(Permission::all());
       
        //Guest
        $guest = Role::create(['name' => 'learner']);
        $guest->givePermissionTo([
           // 'game-instances.play',
        ]);

        //User Admin
        $user = User::find(1); 
        $user->assignRole('admin');

        $user = User::find(2); 
        $user->assignRole('learner');
    }
}
