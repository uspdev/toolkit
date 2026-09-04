@extends('laravel-usp-theme::master')

@section('title', 'Cadastros auxiliares - Cursos de graduação')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-1">Cadastros auxiliares <i class="fas fa-angle-right"></i> Cursos de graduação</h4>
      <p class="text-muted mb-0">Consulta demonstrativa usando <code>CursosGraduacaoClientInterface</code>.</p>
    </div>
  </div>

  @if (blank(config('cadastros-auxiliares-client.base_url')))
    <div class="alert alert-warning" role="alert">
      Configure <code>CADASTROS_AUXILIARES_URL</code> e <code>CADASTROS_AUXILIARES_PASSWORD</code> no arquivo <code>.env</code> para consultar o serviço.
    </div>
  @endif

  <form method="GET" action="{{ route('cadastros-auxiliares.cursos-graduacao') }}" class="form-inline mb-3">
    <label class="sr-only" for="busca">Pesquisar</label>
    <input id="busca" class="form-control mr-2" type="search" name="busca" value="{{ $busca }}" placeholder="Código, curso ou setor">
    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Consultar</button>
    @if ($busca !== '')
      <a class="btn btn-outline-secondary ml-2" href="{{ route('cadastros-auxiliares.cursos-graduacao') }}">Limpar</a>
    @endif
  </form>

  <p class="text-muted">{{ $cursos->count() }} {{ $cursos->count() === 1 ? 'curso encontrado' : 'cursos encontrados' }}.</p>

  @if ($cursos->isEmpty())
    <div class="alert alert-light border" role="alert">
      Nenhum curso foi retornado pela consulta.
    </div>
  @else
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Código</th>
            <th scope="col">Curso</th>
            <th scope="col">Cód. setor</th>
            <th scope="col">Setor</th>
            <th scope="col">Sigla setor</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cursos as $curso)
            <tr>
              <td>{{ $curso['codcur'] ?? '-' }}</td>
              <td>{{ $curso['nomcur'] ?? '-' }}</td>
              <td>{{ $curso['codset'] ?? '-' }}</td>
              <td>{{ $curso['nomset'] ?? '-' }}</td>
              <td>{{ $curso['nomabvset'] ?? '-' }}</td>
              <td>
                @if (isset($curso['codcur']))
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('cadastros-auxiliares.curso-graduacao', $curso['codcur']) }}">Ver</a>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection
