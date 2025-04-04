<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SituacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $situacoes = [
            'Em análise',
            'Em produção',
            'Concluído',
            'Cancelado',
        ];

        foreach ($situacoes as $situacao) {
            \App\Models\Situacao::create([
                'descricao' => $situacao,
            ]);
        }
    }
}
