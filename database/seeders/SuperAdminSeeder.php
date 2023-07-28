<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Persona;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       /*  $usuario = User::create([
            'nombre' => 'Josselin Idrovo',
            'email' => 'josselin.idrovog@ug.edu.ec',
            'password' => bcrypt('0706965775')
        ]); */
        //$rol = Role::create(['name' => 'Administrador']);
       //$permisos = Permission::pluck('id', 'id')->all();
        //$rol->syncPermissions($permisos);
       /*  $usuario ->assignRole('Administrador'); */

    }
}
