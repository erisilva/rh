<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Pedido extends Model
{
    protected $fillable = [
        'motivo_id',
        'situacao_id',
        'nome',
        'cpf',
        'cargo',
        'setor',
        'nota',
        'gestor',
        'matricula',
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fim' => 'datetime',
    ];

    public function motivo() : BelongsTo
    {
        return $this->belongsTo(Motivo::class);
    }

    public function situacao() : BelongsTo
    {
        return $this->belongsTo(Situacao::class);
    }

    /*
     *
     * Filter
     *
     */
    public function scopeFilter($query, array $filters) : void
    {
        // start session values if not yet initialized
        if (!session()->exists('pedido_nome')){
            session(['pedido_nome' => '']);
        }
        if (!session()->exists('pedido_matricula')){
            session(['pedido_matricula' => '']);
        }
        if (!session()->exists('pedido_cargo')){
            session(['pedido_cargo' => '']);
        }
        if (!session()->exists('pedido_setor')){
            session(['pedido_setor' => '']);
        }
        if (!session()->exists('pedido_motivo_id')){
            session(['pedido_motivo_id' => '']);
        }
        if (!session()->exists('pedido_situacao_id')){
            session(['pedido_situacao_id' => '']);
        }
        if (!session()->exists('pedido_data_inicio')){
            session(['pedido_data_inicio' => '']);
        }
        if (!session()->exists('pedido_data_fim')){
            session(['pedido_data_fim' => '']);
        }
        if (!session()->exists('pedido_gestor')){
            session(['pedido_gestor' => '']);
        }
        if (!session()->exists('pedido_matricula')){
            session(['pedido_matricula' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'nome')) {
            session(['pedido_nome' => $filters['nome'] ?? '']);
        }

        if (Arr::exists($filters, 'matricula')) {
            session(['pedido_matricula' => $filters['matricula'] ?? '']);
        }

        if (Arr::exists($filters, 'cargo')) {
            session(['pedido_cargo' => $filters['cargo'] ?? '']);
        }

        if (Arr::exists($filters, 'setor')) {
            session(['pedido_setor' => $filters['setor'] ?? '']);
        }

        if (Arr::exists($filters, 'motivo_id')) {
            session(['pedido_motivo_id' => $filters['motivo_id'] ?? '']);
        }

        if (Arr::exists($filters, 'situacao_id')) {
            session(['pedido_situacao_id' => $filters['situacao_id'] ?? '']);
        }

        if (Arr::exists($filters, 'data_inicio')) {
            session(['pedido_data_inicio' => $filters['data_inicio'] ?? '']);
        }

        if (Arr::exists($filters, 'data_fim')) {
            session(['pedido_data_fim' => $filters['data_fim'] ?? '']);
        }
        if (Arr::exists($filters, 'gestor')) {
            session(['pedido_gestor' => $filters['gestor'] ?? '']);
        }
        if (Arr::exists($filters, 'matricula')) {
            session(['pedido_matricula' => $filters['matricula'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('pedido_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('pedido_nome') . '%');
        }

        if (trim(session()->get('pedido_matricula')) !== '') {
            $query->where('matricula', 'like', '%' . session()->get('pedido_matricula') . '%');
        }

        if (trim(session()->get('pedido_cargo')) !== '') {
            $query->where('cargo', 'like', '%' . session()->get('pedido_cargo') . '%');
        }

        if (trim(session()->get('pedido_setor')) !== '') {
            $query->where('setor', 'like', '%' . session()->get('pedido_setor') . '%');
        }

        if (trim(session()->get('pedido_motivo_id')) !== '') {
            $query->where('motivo_id', session()->get('pedido_motivo_id'));
        }

        if (trim(session()->get('pedido_situacao_id')) !== '') {
            $query->where('situacao_id', session()->get('pedido_situacao_id'));
        }

        if (trim(session()->get('pedido_data_inicio')) !== '') {
            $query->where('created_at', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('pedido_data_inicio')))));
        }

        if (trim(session()->get('pedido_data_fim')) !== '') {
            $query->where('created_at', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('pedido_data_fim')))));
        }

        if (trim(session()->get('pedido_gestor')) !== '') {
            $query->where('gestor', 'like', '%' . session()->get('pedido_gestor') . '%');
        }

        if (trim(session()->get('pedido_matricula')) !== '') {
            $query->where('matricula', 'like', '%' . session()->get('pedido_matricula') . '%');
        }
    }
}
