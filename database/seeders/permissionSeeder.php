<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
    
            //categorías
            'ver-categoria_producto',
            'crear-categoria_producto',
            'editar-categoria_producto',
            'eliminar-categoria_producto',

            //Cliente
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'eliminar-cliente',

            
            //Roles
            'ver-role',
            'crear-role',
            'editar-role',
            'eliminar-role',

            //User
            'ver-user',
            'crear-user',
            'editar-user',
            'eliminar-user',

            //Perfil 
            'ver-perfil',
            'editar-perfil',
            //Prestamos
            'ver-prestamo',
            'crear-prestamo',
            'editar-prestamo',
            'eliminar-prestamo',


            'ver-interes',
            'crear-interes',
            'editar-interes',
            'eliminar-interes',

            'ver-prenda',
            'crear-prenda',
            'editar-prenda',
            'eliminar-prenda',

            'ver-tipopago',
            'crear-tipopago',
            'editar-tipopago',
            'eliminar-tipopago',

            'ver-pago',
            'crear-pago',
            'editar-pago',
            'eliminar-pago',

            'ver-tipo_documento',
            'crear-tipo_documento',
            'editar-tipo_documento',
            'eliminar-tipo_documento',



        ];

        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }
    }
}
