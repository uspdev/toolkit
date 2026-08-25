<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-api-help-modal style="display: none;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title h5">Como usar a API</h2>
        <button type="button" class="close" aria-label="Fechar" data-api-help-close>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="h6">Dono da chave e diretório</h3>
        <p>Uma API Key é criada para um usuário. Esse usuário é o <strong>dono da chave</strong>; não é
          necessariamente a pessoa ou sistema que fará a chamada.</p>
        <p>O endpoint <code>/user</code> sempre identifica o dono da chave. Já o endpoint
          <code>/users</code> consulta o <strong>diretório global</strong> e pode listar os usuários do sistema,
          não apenas o dono.
        </p>
        <p class="mb-4"><strong>Exemplo:</strong> se Maria criar uma chave <code>directory</code>,
          <code>/user</code> retorna Maria e <code>/users</code> retorna a lista de usuários. Para isso,
          Maria precisa ter acesso administrativo. Se esse acesso for removido, a chave continua existindo,
          mas passa a receber <code>403</code>.
        </p>

        <p>Siga estes passos para fazer sua primeira integração:</p>
        <ol>
          <li class="mb-2"><strong>Escolha o papel.</strong> Use <code>personal</code> para consultar o usuário dono
            da chave.
            Use <code>directory</code> quando também precisar listar o diretório global.</li>
          <li class="mb-2"><strong>Crie a chave.</strong> Clique em <strong>Nova API Key</strong>, informe um nome,
            selecione o papel e defina uma expiração opcional.</li>
          <li class="mb-2"><strong>Copie o segredo.</strong> O token completo aparece uma única vez após a criação.
            Guarde-o em um cofre de segredos.</li>
          <li><strong>Faça a chamada.</strong> Envie o token no cabeçalho <code>Authorization: Bearer</code>.</li>
        </ol>

        <h3 class="h6 mt-4">Exemplos:</h3>
        <code class="d-block p-2 bg-light text-break">curl -H "Authorization: Bearer SUA_API_KEY"
          "{{ $userEndpoint }}"</code>
        <code class="d-block p-2 bg-light text-break mt-2">curl -H "Authorization: Bearer SUA_API_KEY"
          "{{ $usersEndpoint }}"</code>

        <h3 class="h6 mt-4">Erros de autenticação:</h3>
        <p class="mb-0"><code>401</code> significa que o token não foi autenticado. <code>403</code> significa que o
          token
          é válido, mas não possui a ability ou a permissão necessária.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-api-help-close>Fechar</button>
      </div>
    </div>
  </div>
</div>
