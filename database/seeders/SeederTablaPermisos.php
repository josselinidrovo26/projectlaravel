<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//spatie
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            //tabla rol
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
            //tabla usuario
            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario',
            //tabla curso
            'ver-curso',
            'crear-curso',
            'editar-curso',
            'borrar-curso',
            //tabla estudiante
            'ver-estudiante',
            'crear-estudiante',
            'editar-estudiante',
            'borrar-estudiante',
             //tabla periodo
             'ver-periodo',
             'crear-periodo',
             'editar-periodo',
             'borrar-periodo',
             //tabla detalles
             'ver-detalles',
             'crear-detalles',
             'editar-detalles',
             'borrar-detalles',
                //tabla pagos
                'ver-pagos',
                'crear-pagos',
                'editar-pagos',
                'borrar-pagos',
                //tabla bancos
                'ver-bancos',
                'crear-bancos',
                'editar-bancos',
                'borrar-bancos',
                //tabla reportes
                'ver-reportes',
                'crear-reportes',
                'editar-reportes',
                'borrar-reportes',
                //tabla auditoria
                'ver-auditoria',
                'crear-auditoria',
                'editar-auditoria',
                'borrar-auditoria',
            //tabla configuracion
            'ver-configuracion',
            'crear-configuracion',
            'editar-configuracion',
            'borrar-configuracion',
            //tabla blogs
             'ver-blog',
            'crear-blog',
            'editar-blog',
            'borrar-blog',
             //tabla biografia
            'ver-biografia',
             'crear-biografia',
             'editar-biografia',
             'borrar-biografia',
              //tabla reuniones
             'ver-reunion',
              'crear-reunion',
              'editar-reunion',
              'borrar-reunion',



        ];
        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }

    }
}
