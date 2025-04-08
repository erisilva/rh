@extends('layouts.forms')

@section('title', 'Título do Formulário')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="py-4">Obrigado por preencher o formulário. As informações foram enviadas com sucesso.</h1>

                <a href="{{ route('forms.index') }}" class="btn btn-secondary btn-lg" role="button">
                    <x-icon icon='arrow-left-square' />
                    Clique aqui para fazer novo cadastro
                </a>
            </div>
        </div>
    </div>
@endsection
