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
            'Motivo 1',
            'Motivo 2',
            'Motivo 3',
            'Motivo 4',
            'Motivo 5',
            'Motivo 6',
            'Motivo 7',
        ];

        foreach ($motivos as $motivo) {
            \App\Models\Motivo::create([
                'descricao' => $motivo,
            ]);
        }
    }
}
