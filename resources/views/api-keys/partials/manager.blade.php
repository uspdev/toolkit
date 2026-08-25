<section class="card">
  <div class="card-body">
    {{-- Não apareceu a msg do laravel usp theme --}}
    @if (session('api-keys.error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('api-keys.error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    @if (!$canIssueDirectory)
      <div class="alert alert-info" role="status">
        <strong>Role Diretório:</strong> disponível somente para usuários com a
        permissão <code>administrativa</code> ou com o Gate hierárquico
        <code>admin</code>. A role <strong>Pessoal</strong> continua disponível
        para o próprio usuário.
      </div>
    @endif

    {{-- Componente de gerenciamento de chaves API fornecido pela biblioteca --}}
    <x-api-keys::manager :owner="$user" owner-alias="user" />
  </div>
</section>
