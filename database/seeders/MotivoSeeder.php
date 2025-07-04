<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motivos = [
            ['id' => 1, 'descricao' => 'Outros'],
            ['id' => 2, 'descricao' => 'Contratação'],
            ['id' => 3, 'descricao' => 'Demissão'],
            ['id' => 4, 'descricao' => 'Férias com apenas um período'],
            ['id' => 5, 'descricao' => 'Férias com dois períodos'],
            ['id' => 6, 'descricao' => 'Licença Maternidade'],
            ['id' => 7, 'descricao' => 'Licença Médica (até 15 dias)'],
            ['id' => 8, 'descricao' => 'Licença Médica (acima de 15 dias)'],
            ['id' => 9, 'descricao' => 'Transferência'],
        ];

        foreach ($motivos as $motivo) {
            \App\Models\Motivo::create([
            'id' => $motivo['id'],
            'descricao' => $motivo['descricao'],
            ]);
        }
    }
}
