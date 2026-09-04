@extends('laravel-usp-theme::master')

@section('title', 'Cadastros auxiliares - Curso de graduação')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Cadastros auxiliares <i class="fas fa-angle-right"></i> Curso {{ $codcur }}</h4>
    <a class="btn btn-outline-secondary" href="{{ route('cadastros-auxiliares.cursos-graduacao') }}">Voltar</a>
  </div>

  @if ($curso === null)
    <div class="alert alert-warning" role="alert">
      O curso não foi encontrado ou o serviço de cadastros auxiliares não está disponível.
    </div>
  @else
    <div class="card">
      <div class="card-header">Resultado de <code>obter({{ $codcur }})</code></div>
      <div class="card-body p-0">
        <dl class="row mb-0 p-3">
          <dt class="col-sm-3">ID</dt>
          <dd class="col-sm-9">{{ $curso['id'] ?? '-' }}</dd>

          <dt class="col-sm-3">Código</dt>
          <dd class="col-sm-9">{{ $curso['codcur'] ?? '-' }}</dd>

          <dt class="col-sm-3">Curso</dt>
          <dd class="col-sm-9">{{ $curso['nomcur'] ?? '-' }}</dd>

          <dt class="col-sm-3">Código do setor</dt>
          <dd class="col-sm-9">{{ $curso['codset'] ?? '-' }}</dd>

          <dt class="col-sm-3">Setor</dt>
          <dd class="col-sm-9">{{ $curso['nomset'] ?? '-' }}</dd>

          <dt class="col-sm-3">Sigla do setor</dt>
          <dd class="col-sm-9">{{ $curso['nomabvset'] ?? '-' }}</dd>
        </dl>
      </div>
    </div>
  @endif
@endsection
