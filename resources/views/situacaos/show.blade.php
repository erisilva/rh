@extends('layouts.app')

@section('title', 'Situações' . ' - ' . __('Show'))

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
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Setor">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ 'Descrição : ' . $situacao->descricao }}
    </li>
  </ul>
</x-card>

@can('situacao-delete')
<x-btn-trash />
@endcan

<x-btn-back route="situacaos.index" />

@can('situacao-delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('situacaos.destroy', $situacao->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
