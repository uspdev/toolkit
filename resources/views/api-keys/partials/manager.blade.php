<section class="card">
  <div class="card-body">
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
