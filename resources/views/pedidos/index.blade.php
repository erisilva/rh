@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('pedidos.index') }}">Pedidos</a>
                </li>
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            @can('pedido-create')
                <a class="btn btn-primary" href="{{ route('pedidos.create') }}" role="button"><x-icon icon='file-earmark' />
                    {{ __('New') }}</a>
            @endcan

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}</button>

            @can('pedido-export')
                <x-dropdown-menu title='Reports' icon='printer'>

                    <li>
                        <a class="dropdown-item"
                            href="{{route('pedidos.export.csv', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cargo' => request()->input('cargo'), 'setor' => request()->input('setor'), 'situacao' => request()->input('situacao'), 'motivo' => request()->input('motivo')])}}"><x-icon
                                icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' CSV' }}</a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                            href="{{route('pedidos.export.pdf', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cargo' => request()->input('cargo'), 'setor' => request()->input('setor'), 'situacao' => request()->input('situacao'), 'motivo' => request()->input('motivo')])}}"><x-icon
                                icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
                    </li>

                </x-dropdown-menu>
            @endcan

        </x-btn-group>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Enviado em</th>
                        <th>Nome do Colaborador</th>
                        <th>CPF</th>
                        <th>Cargo</th>
                        <th>Setor</th>
                        <th>Motivo</th>
                        <th>Situação</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                        <tr>
                            <td class="text-nowrap">
                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-nowrap">
                                {{ $pedido->nome }}
                            </td>
                            <td class="text-nowrap">
                                {{ $pedido->cpf }}
                            </td>
                            <td>
                                {{ $pedido->cargo }}
                            </td>
                            <td>
                                {{ $pedido->setor }}
                            </td>
                            <td>
                                {{ $pedido->motivo->descricao }}
                            </td>
                            <td>
                                {{ $pedido->situacao->descricao }}
                            </td>
                            <td>
                                <x-btn-group label='Opções'>

                                    @can('pedido-edit')
                                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-primary btn-sm"
                                            role="button"><x-icon icon='pencil-square' /></a>
                                    @endcan

                                    @can('pedido-show')
                                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-info btn-sm"
                                            role="button"><x-icon icon='eye' /></a>
                                    @endcan

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :query="$pedidos" />

    </div>

    <x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>

        <div class="container">
            <form method="GET" action="{{ route('pedidos.index') }}">

                <div class="row g-3">

                    <div class="col-md-12">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="{{ session()->get('pedido_nome') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo"
                            value="{{ session()->get('pedido_cargo') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="setor" class="form-label">Setor</label>
                        <input type="text" class="form-control" id="setor" name="setor"
                            value="{{ session()->get('pedido_setor') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="motivo_id" class="form-label">Motivo</label>
                        <select class="form-select" id="motivo_id" name="motivo_id">
                            <option value="" selected="true">Exibir Todos ...</option>
                            @foreach($motivos as $motivo)
                            <option value="{{ $motivo->id }}" @selected(session()->get('pedido_motivo_id') == $motivo->id) >
                              {{ $motivo->descricao }}
                            </option>
                            @endforeach
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label for="situacao_id" class="form-label">Situação</label>
                        <select class="form-select" id="situacao_id" name="situacao_id">
                            <option value="" selected="true">Exibir Todos ...</option>
                            @foreach($situacaos as $situacao)
                            <option value="{{ $situacao->id }}" @selected(session()->get('pedido_situacao_id') == $situacao->id) >
                              {{ $situacao->descricao }}
                            </option>
                            @endforeach
                        </select>
                      </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' />
                            {{ __('Search') }}</button>

                        <a href="{{ route('pedidos.index', ['nome' => '', 'matricula' => '', 'cargo' => '', 'setor' => '', 'situacao_id' => '', 'motivo_id' => '']) }}"
                            class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars' /> {{ __('Reset') }}</a>
                    </div>

                </div>

            </form>
        </div>


    </x-modal-filter>

@endsection
@section('script-footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var perpage = document.getElementById('perpage');
            perpage.addEventListener('change', function () {
                perpage = this.options[this.selectedIndex].value;
                window.open("{{ route('pedidos.index') }}" + "?perpage=" + perpage, "_self");
            });
        });
    </script>
@endsection
