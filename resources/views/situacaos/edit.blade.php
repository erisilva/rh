@extends('layouts.app')

@section('title', 'Situações' . ' - ' . __('Edit'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('situacaos.index') }}">
          Situações
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Edit') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
    <x-flash-message status='success'  message='message' />

    <form method="POST" action="{{ route('situacaos.update', $situacao->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-12">
        <label for="descricao" class="form-label">{{ __('Description') }}</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? $situacao->descricao }}">
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <x-icon icon='pencil-square' />{{ __('Edit') }}
        </button>
      </div>
    </div>
   </form>
</div>

<div class="container py-4">
    <div class="float-sm-end">

        @can('situacao-create')
            <a href="{{ route('situacaos.create') }}" class="btn btn-primary btn-lg" role="button">
                <x-icon icon='file-earmark' />
                {{ __('New') }}
            </a>
        @endcan

        <a href="{{ route('situacaos.index') }}" class="btn btn-secondary btn-lg" role="button">
            <x-icon icon='arrow-left-square' />
            Situações
        </a>

    </div>
</div>
@endsection
