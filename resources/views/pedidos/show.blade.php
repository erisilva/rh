@extends('layouts.app')

@section('title', 'Pedidos' . ' - ' . __('Show'))

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pedidos.index') }}">
                        Pedidos
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Show') }}
                </li>
            </ol>
        </nav>
    </div>

    <form>

        <div class="container">
            <div class="row g-3">

                <div class="col-md-9">
                    <label for="nome" class="form-label">Nome do Colaborador</label>
                    <input type="text" class="form-control" name="nome" value="{{ $pedido->nome }}" disabled>
                </div>

                <div class="col-md-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" value="{{ $pedido->cpf }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input type="text" class="form-control" name="cargo" value="{{ $pedido->cargo }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="setor" class="form-label">Setor/Unidade</label>
                    <input type="text" class="form-control" name="setor" value="{{ $pedido->setor }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="gestor" class="form-label">Gestor</label>
                    <input type="text" class="form-control" name="gestor" value="{{ $pedido->gestor }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" name="matricula" value="{{ $pedido->matricula }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="motivo" class="form-label">Motivo</label>
                    <input type="text" class="form-control" name="motivo" value="{{ $pedido->motivo->descricao }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="situacao" class="form-label">Situação</label>
                    <input type="text" class="form-control" name="situacao" value="{{ $pedido->situacao->descricao }}" disabled>
                </div>

                <div class="col-md-12">
                    <label for="nota" class="form-label">Nota</label>
                    <textarea class="form-control" name="nota" rows="5" disabled>{{ $pedido->nota }}</textarea>
                </div>

            </div>
        </div>


    </form>

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
