<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 200);
            $table->string('cargo', 150);
            $table->string('setor', 150);
            $table->text('nota');
            $table->string('cpf');
            $table->foreignId('motivo_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('situacao_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['situacao_id']);
            $table->dropForeign(['motivo_id']);
        });

        Schema::dropIfExists('pedidos');
    }
};
