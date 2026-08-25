<div class="row mb-4">
  <div class="col-lg-6 mb-3">
    <section class="card h-100">
      <div class="card-body">
        <h2 class="h5">Endpoints de integração</h2>
        <p class="text-muted">Copie uma URL para consultar a API.</p>
        <label class="form-label" for="api-user-endpoint">Dono da chave</label>
        <div class="input-group mb-3">
          <input id="api-user-endpoint" class="form-control" type="text" value="{{ $userEndpoint }}" readonly>
          <button class="btn btn-outline-secondary" type="button" data-copy-target="api-user-endpoint">Copiar</button>
        </div>

        <label class="form-label" for="api-users-endpoint">Diretório</label>
        <div class="input-group">
          <input id="api-users-endpoint" class="form-control" type="text" value="{{ $usersEndpoint }}" readonly>
          <button class="btn btn-outline-secondary" type="button" data-copy-target="api-users-endpoint">Copiar</button>
        </div>
      </div>
    </section>
  </div>

  <div class="col-lg-5 mb-3">
    <section class="card h-100">
      <div class="card-body">
        <h2 class="h5">Como autenticar</h2>
        <p class="mb-2">Para integrações, envie a chave no cabeçalho:</p>
        <code class="d-block p-2 bg-light">Authorization: Bearer SUA_API_KEY</code>
        <p class="mb-2 mt-3">Quando não for possível enviar cabeçalhos, use:</p>
        <code class="d-block p-2 bg-light">{{ $userEndpoint }}?{{ $queryParameter }}=SUA_API_KEY</code>
        <p class="small text-muted mb-0 mt-2">Prefira o cabeçalho Bearer: chaves em URLs podem aparecer em histórico,
          logs e ferramentas de monitoramento. O parâmetro fica disponível somente como fallback de demonstração.</p>
      </div>
    </section>
  </div>
</div>
