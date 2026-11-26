<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Resetear caché de roles (CRUCIAL al desarrollar)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definir todos los permisos del sistema
        $permissions = [
            'ver dashboard',
            'gestionar usuarios',
            'gestionar roles',
            
            'ver categoria', 'crear categoria', 'editar categoria', 'eliminar categoria',
            
            'ver entregante', 'crear entregante', 'editar entregante', 'eliminar entregante',
            
            'ver recepcion', 'crear recepcion', 'editar recepcion', 'eliminar recepcion',
            
            'ver material', 'crear material', 'editar material', 'eliminar material',
            
            'ver asignacion', 'crear asignacion', 'editar asignacion', 'eliminar asignacion',
            
            'ver recuperacion', 'crear recuperacion', 'editar recuperacion', 'eliminar recuperacion',
            
            'ver componente', 'crear componente', 'editar componente', 'eliminar componente',
            
            'ver inventario', 'crear inventario', 'editar inventario', 'eliminar inventario',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 3. Crear Rol: ADMINISTRADOR
        $admin = Role::firstOrCreate(['name' => 'Administrador']);
        $admin->syncPermissions(Permission::all());

        // 4. Crear Rol: OPERADOR
        $operador = Role::firstOrCreate(['name' => 'Operador']);
        $operador->syncPermissions([
            'ver dashboard',
            'ver entregante', 'crear entregante', 'editar entregante',
            'ver recepcion', 'crear recepcion', 'editar recepcion',
            'ver material', 'crear material', 'editar material',
            'ver categoria',
            'ver asignacion',
        ]);

        // 5. Crear Rol: TÉCNICO
        $tecnico = Role::firstOrCreate(['name' => 'Técnico']);
        $tecnico->syncPermissions([
            'ver dashboard',
            'ver categoria', 'ver entregante', 'ver recepcion', 'ver material',
            'ver asignacion', 'editar asignacion',
            'ver recuperacion', 'crear recuperacion', 'editar recuperacion',
            'ver componente', 'crear componente', 'editar componente',
            'ver inventario', 'editar inventario',
        ]);

        $this->command->info('✅ Roles y permisos creados exitosamente.');
    }
}