@extends('layouts.app')

@section('title', 'Situações')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('situacaos.index') }}">
                        Situações
                    </a>
                </li>
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            @can('situacao-create')
                <a class="btn btn-primary" href="{{ route('situacaos.create') }}" role="button"><x-icon icon='file-earmark' />
                    {{ __('New') }}</a>
            @endcan

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}</button>

            @can('situacao-export')
                <x-dropdown-menu title='Reports' icon='printer'>

                    <li>
                        <a class="dropdown-item" href="{{route('situacaos.export.csv')}}"><x-icon
                                icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' CSV' }}</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{route('situacaos.export.pdf')}}"><x-icon icon='file-pdf-fill' />
                            {{ __('Export') . ' PDF' }}</a>
                    </li>

                </x-dropdown-menu>
            @endcan

        </x-btn-group>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($situacaos as $situacao)
                        <tr>
                            <td>
                                {{$situacao->descricao}}
                            </td>
                            <td>
                                <x-btn-group label='Opções'>

                                    @can('situacao-edit')
                                        <a href="{{route('situacaos.edit', $situacao->id)}}" class="btn btn-primary btn-sm"
                                            role="button"><x-icon icon='pencil-square' /></a>
                                    @endcan

                                    @can('situacao-show')
                                        <a href="{{route('situacaos.show', $situacao->id)}}" class="btn btn-info btn-sm"
                                            role="button"><x-icon icon='eye' /></a>
                                    @endcan

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :query="$situacaos" />

    </div>

    <x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'></x-modal-filter>

@endsection
@section('script-footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var perpage = document.getElementById('perpage');
            perpage.addEventListener('change', function () {
                perpage = this.options[this.selectedIndex].value;
                window.open("{{ route('situacaos.index') }}" + "?perpage=" + perpage, "_self");
            });
        });
    </script>
@endsection
