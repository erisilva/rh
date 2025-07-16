@extends('layouts.app')

@section('title', ' Pedidos' . ' - ' . __('New'))

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pedidos.index') }}">Pedidos</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('New') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <form method="POST" action="{{ route('pedidos.store') }}">
            @csrf
            <div class="row g-3">

                <div class="col-md-9">
                    <label for="nome" class="form-label">Nome Completo <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                        value="{{ old('nome') ?? '' }}">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="cpf" class="form-label">CPF <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf"
                        value="{{ old('cpf') ?? '' }}">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-6">
                    <label for="cargo" class="form-label">Cargo <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('cargo') is-invalid @enderror" name="cargo"
                        value="{{ old('cargo') ?? '' }}">
                    @error('cargo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="setor" class="form-label">Setor <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('setor') is-invalid @enderror" name="setor"
                        value="{{ old('setor') ?? '' }}">
                    @error('setor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="nota">Descreva a solicitação: <strong class="text-danger">(*)</strong></label>
                    <textarea class="form-control" name="nota" rows="5" required>{{ old('nota') ?? '' }}</textarea>
                    @error('nota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- motivo --}}
                <div class="col-md-6">
                    <label for="motivo_id" class="form-label">Motivo <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="motivo_id" name="motivo_id">
                        <option value="" selected>Clique ...</option>
                        @foreach($motivos as $motivo)
                            <option value="{{ $motivo->id }}" @selected(old('motivo_id') == $motivo->id)>
                                {{ $motivo->descricao }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('motivo_id'))
                        <div class="text-danger">
                            {{ $errors->first('motivo_id') }}
                        </div>
                    @endif
                </div>

                {{-- situacao --}}
                <div class="col-md-6">
                    <label for="situacao_id" class="form-label">Situacão <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="situacao_id" name="situacao_id">
                        <option value="" selected>Clique ...</option>
                        @foreach($situacaos as $situacao)
                            <option value="{{ $situacao->id }}" @selected(old('situacao_id') == $situacao->id)>
                                {{ $situacao->descricao }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('situacao_id'))
                        <div class="text-danger">
                            {{ $errors->first('situacao_id') }}
                        </div>
                    @endif
                </div>



                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> {{ __('Save') }}</button>
                </div>

            </div>
        </form>
    </div>

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
@endsection
@section('script-footer')
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $("#cpf").inputmask({ "mask": "999.999.999-99" });

        });
    </script>

@endsection
