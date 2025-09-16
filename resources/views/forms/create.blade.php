@extends('layouts.forms')

@section('title', 'Formulário de Solicitações de Pedido')

@section('content')
    <div class="container py-4 text-bg-light">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1 class="py-3">Formulário de Gestão de Terceirizados</h1>

                <div class="alert alert-light py-3" role="alert">
                    <p>
                        Este formulário destina-se ao registro e encaminhamento de solicitações relacionadas à gestão de colaboradores terceirizados. Por meio deste canal, devem ser formalizadas demandas como: solicitação de férias, desligamentos, substituição de colaborador, licenças médicas, licença maternidade e novas contratações. O preenchimento correto e completo das informações contribuirá para maior agilidade no atendimento e na tramitação das solicitações junto aos setores responsáveis.
                    </p>
                    <strong>Observação:</strong> Campos com <strong class="text-danger">(*)</strong> são de preenchimento obrigatório.
                </div>

                <form method="POST" action="{{ route('forms.store') }}">
                    @csrf


                    <div class="row mb-3">
                        <label for="nome" class="col-md-4 col-form-label text-md-end">Nome do Colaborador: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror"
                                name="nome" value="{{ old('nome') }}" required>

                            @error('nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cpf" class="col-md-4 col-form-label text-md-end">CPF: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror"
                                name="cpf" value="{{ old('cpf') }}" required>

                            @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cargo" class="col-md-4 col-form-label text-md-end">Cargo: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <input id="cargo" type="text" class="form-control @error('cargo') is-invalid @enderror"
                                name="cargo" value="{{ old('cargo') }}" required>

                            @error('cargo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="setor" class="col-md-4 col-form-label text-md-end">Setor/Unidade: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <input id="setor" type="text" class="form-control @error('setor') is-invalid @enderror"
                                name="setor" value="{{ old('setor') }}" required>

                            @error('setor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="gestor" class="col-md-4 col-form-label text-md-end">Nome do Gestor: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <input id="gestor" type="text" class="form-control @error('gestor') is-invalid @enderror"
                                name="gestor" value="{{ old('gestor') }}" required>

                            @error('gestor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="matricula" class="col-md-4 col-form-label text-md-end">Matrícula do Gestor: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <input id="matricula" type="text" class="form-control @error('matricula') is-invalid @enderror"
                                name="matricula" value="{{ old('matricula') }}" required>

                            @error('matricula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="motivo_id" class="col-md-4 col-form-label text-md-end">Motivo: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <select class="form-select" id="motivo_id" name="motivo_id">
                                <option value="" selected>Escolha ...</option>
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
                    </div>

                    <div class="row mb-3">
                        <label for="nota" class="col-md-4 col-form-label text-md-end">Descrição do pedido: <strong
                                class="text-danger">(*)</strong></label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="nota" rows="5" required>{{ old('nota') ?? '' }}</textarea>
                        </div>

                        @error('nota')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="captcha_img" class="col-sm-4 col-form-label"></label>
                        <div class="col-md-6">
                            <div class="captcha_img">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger reload" id="reload"
                                    onclick="location.reload();">
                                    <span><x-icon icon='arrow-clockwise' /></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="captcha" class="col-sm-4 col-form-label text-end">Captcha  <strong
                            class="text-danger">(*)</strong></label>
                        <div class="col-md-6">
                            <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror"
                                name="captcha" required autocomplete="captcha" placeholder="Digite o código da imagem acima">
                            @error('captcha')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                <x-icon icon='plus-circle' /> Enviar
                            </button>
                        </div>
                    </div>


                </form>

            </div>
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
