<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permission list for users table
        DB::table('permissions')->insert([
            'name' => 'user-index',
            'description' => 'Lista de operadores',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-create',
            'description' => 'Registrar novo operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-edit',
            'description' => 'Alterar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-delete',
            'description' => 'Excluir operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-show',
            'description' => 'Mostrar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-export',
            'description' => 'Exportação de dados dos operadores',
        ]);


        // permission list for roles table
        DB::table('permissions')->insert([
            'name' => 'role-index',
            'description' => 'Lista de perfis',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-create',
            'description' => 'Registrar novo perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-edit',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-delete',
            'description' => 'Excluir perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-show',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-export',
            'description' => 'Exportação de dados dos perfis',
        ]);

        // permission list for permissions table
        DB::table('permissions')->insert([
            'name' => 'permission-index',
            'description' => 'Lista de permissões',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-create',
            'description' => 'Registrar nova permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-edit',
            'description' => 'Alterar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-delete',
            'description' => 'Excluir permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-show',
            'description' => 'Mostrar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-export',
            'description' => 'Exportação de dados das permissões',
        ]);

        // permission list for logs table
        DB::table('permissions')->insert([
            'name' => 'log-index',
            'description' => 'Lista de permissões',
        ]);
        DB::table('permissions')->insert([
            'name' => 'log-show',
            'description' => 'Mostrar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'log-export',
            'description' => 'Exportação de dados das permissões',
        ]);

        // permission list for motivos table

        DB::table('permissions')->insert([
            'name' => 'motivo-index',
            'description' => 'Lista de motivos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'motivo-create',
            'description' => 'Registrar novo motivo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'motivo-edit',
            'description' => 'Alterar dados do motivo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'motivo-delete',
            'description' => 'Excluir motivo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'motivo-show',
            'description' => 'Mostrar dados do motivo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'motivo-export',
            'description' => 'Exportação de dados dos motivos',
        ]);

        // permission list for pedidos table

        DB::table('permissions')->insert([
            'name' => 'pedido-index',
            'description' => 'Lista de pedidos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'pedido-create',
            'description' => 'Registrar novo pedido',
        ]);
        DB::table('permissions')->insert([
            'name' => 'pedido-edit',
            'description' => 'Alterar dados do pedido',
        ]);
        DB::table('permissions')->insert([
            'name' => 'pedido-delete',
            'description' => 'Excluir pedido',
        ]);
        DB::table('permissions')->insert([
            'name' => 'pedido-show',
            'description' => 'Mostrar dados do pedido',
        ]);
        DB::table('permissions')->insert([
            'name' => 'pedido-export',
            'description' => 'Exportação de dados dos pedidos',
        ]);

        // permission list for situacoes table
        DB::table('permissions')->insert([
            'name' => 'situacao-index',
            'description' => 'Lista de situações',
        ]);
        DB::table('permissions')->insert([
            'name' => 'situacao-create',
            'description' => 'Registrar nova situação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'situacao-edit',
            'description' => 'Alterar dados da situação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'situacao-delete',
            'description' => 'Excluir situação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'situacao-show',
            'description' => 'Mostrar dados da situação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'situacao-export',
            'description' => 'Exportação de dados das situações',
        ]);

    }
}
