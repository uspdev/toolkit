@extends('laravel-usp-theme::master')

@include('laravel-usp-theme::blocos.datatable-simples')

@section('title', 'API do Toolkit')

@section('content')
  <div class="d-flex flex-wrap align-items-start justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1">API do Toolkit</h1>
      <p class="text-muted mb-0">Crie e gerencie as chaves que dão acesso aos seus dados nesta aplicação.</p>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-lg-6 mb-3">
      <section class="card h-100">
        <div class="card-body">
          <h2 class="h5">Endpoint de integração</h2>
          <p class="text-muted">Este endpoint devolve os dados do usuário dono da chave em JSON.</p>
          <label class="form-label" for="api-user-endpoint">URL</label>
          <div class="input-group">
            <input id="api-user-endpoint" class="form-control" type="text" value="{{ $userEndpoint }}" readonly>
            <button class="btn btn-outline-secondary" type="button" data-copy-target="api-user-endpoint">Copiar</button>
          </div>
        </div>
      </section>
    </div>

    <div class="col-lg-6 mb-3">
      <section class="card h-100">
        <div class="card-body">
          <h2 class="h5">Como autenticar</h2>
          <p class="mb-2">Para integrações, envie a chave no cabeçalho:</p>
          <code class="d-block p-2 bg-light">Authorization: Bearer SUA_API_KEY</code>
          <p class="mb-2 mt-3">Quando não for possível enviar cabeçalhos, use:</p>
          <code class="d-block p-2 bg-light">{{ $userEndpoint }}?{{ $queryParameter }}=SUA_API_KEY</code>
          <p class="small text-muted mb-0 mt-2">Prefira o cabeçalho Bearer: URLs podem ser registradas em histórico e
            logs.</p>
        </div>
      </section>
    </div>
  </div>

  <section class="card">
    <div class="card-body">
      {{-- Componete de gerenciamento de chaves API fornecido pela biblioteca --}}
      <x-api-keys::manager :owner="$user" owner-alias="user" />
    </div>
  </section>
@endsection

@section('javascripts_bottom')
  @parent
  <script>
    document.querySelectorAll('[data-copy-target]').forEach((button) => {
      button.addEventListener('click', async () => {
        const input = document.getElementById(button.dataset.copyTarget);

        if (!input || !navigator.clipboard) return;

        await navigator.clipboard.writeText(input.value);
        const label = button.textContent;
        button.textContent = 'Copiada';
        window.setTimeout(() => button.textContent = label, 1500);
      });
    });
  </script>
@endsection
