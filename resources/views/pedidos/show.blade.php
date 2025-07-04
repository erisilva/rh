@extends('layouts.app')

@section('title', 'Pedidos' . ' - ' . __('Show'))

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pedidos.index') }}">
                        {{ __('Permissions') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Show') }}
                </li>
            </ol>
        </nav>
    </div>

    <x-card title="Pedido">
        <ul class="list-group list-group-flush">

            <li class="list-group-item">
                {{ 'Nome : ' . $pedido->nome }}
            </li>

            <li class="list-group-item">
                {{ 'Cargo : ' . $pedido->cargo }}
            </li>

            <li class="list-group-item">
                {{ 'Setor : ' . $pedido->setor }}
            </li>

            <li class="list-group-item">
                {{ 'Situação : ' . $pedido->situacao->descricao }}
            </li>

            <li class="list-group-item">
                {{ 'Motivo : ' . $pedido->motivo->descricao }}
            </li>

        </ul>
    </x-card>

    @can('pedido-delete')
        <x-btn-trash />
    @endcan

    <div class="container py-4">
        <div class="float-sm-end">

            @can('pedido-create')
                <a href="{{ route('pedidos.create') }}" class="btn btn-primary btn-lg" role="button">
                    <x-icon icon='file-earmark' />
                    {{ __('New') }}
                </a>
            @endcan

            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary btn-lg" role="button">
                <x-icon icon='arrow-left-square' />
                Pedidos
            </a>

        </div>
    </div>

    @can('pedido-delete')
        <x-modal-trash class="modal-sm">
            <form method="post" action="{{route('pedidos.destroy', $pedido->id)}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <x-icon icon='trash' /> {{ __('Delete this record?') }}
                </button>
            </form>
        </x-modal-trash>
    @endcan

@endsection
