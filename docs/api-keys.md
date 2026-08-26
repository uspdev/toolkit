# API Keys no Toolkit

## Visão geral

O Toolkit usa o pacote `uspdev/api-keys` para emitir e autenticar credenciais
vinculadas a um `App\Models\User`. A aplicação hospedeira define os papéis,
as abilities e as regras locais de autorização; o pacote fornece a persistência,
o gerenciamento pela interface Blade e o middleware de autenticação.

### Fluxo completo

```text
Usuário autenticado
  └─ GET /keys
       └─ <x-api-keys::manager> (pacote)
            └─ POST /api-keys/user/{owner}/keys
                 ├─ Gate manageApiKeys: quem pode administrar o owner?
                 ├─ EnsureApiKeyRoleCanBeIssued: owner pode ter directory?
                 └─ ApiKeyService: grava prefixo e hash; exibe segredo uma vez

Cliente de integração
  └─ GET /api/toolkit/user ou /api/toolkit/users + Bearer
       └─ uspdevApiKeys autentica e injeta request.attributes['apiKey']
            └─ controller chama $apiKey->allows('<ability>')
                 └─ User::abilities($role) recalcula as abilities do owner
```

Há, portanto, duas autorizações distintas. A autorização **de gerenciamento**
decide quem pode criar, renovar ou revogar uma chave. A autorização **de uso**
decide o que uma chave já emitida pode ler. Uma não substitui a outra.

## Componentes e responsabilidades

| Componente | Responsabilidade |
| --- | --- |
| [`composer.json`](../composer.json) | Declara a dependência `uspdev/api-keys` e o repositório do pacote. |
| [`database/migrations/2026_07_13_000000_create_uspdev_api_keys_table.php`](../database/migrations/2026_07_13_000000_create_uspdev_api_keys_table.php) | Cria a tabela `uspdev_api_keys`. |
| [`config/api-keys.php`](../config/api-keys.php) | Adapta a configuração do pacote ao Toolkit: owner, papéis, middleware e credencial. |
| [`app/Models/User.php`](../app/Models/User.php) | Implementa `HasApiKeys`, declara as abilities efetivas de cada papel e é o dono da chave. |
| [`app/Providers/AuthServiceProvider.php`](../app/Providers/AuthServiceProvider.php) | Define quem pode administrar chaves de um owner. |
| [`app/Http/Middleware/EnsureApiKeyRoleCanBeIssued.php`](../app/Http/Middleware/EnsureApiKeyRoleCanBeIssued.php) | Impede emissão ou renovação indevida do papel elevado. |
| [`app/Http/Controllers/ApiKeysController.php`](../app/Http/Controllers/ApiKeysController.php) e [`resources/views/api-keys`](../resources/views/api-keys) | Exibem a tela web `/keys`, que incorpora o componente do pacote. |
| [`app/Http/Controllers/Api/UserApiController.php`](../app/Http/Controllers/Api/UserApiController.php) e [`routes/api.php`](../routes/api.php) | Protegem e implementam as APIs de integração. |

O pacote não foi alterado. As regras que dependem de permissões e Gates deste
projeto ficam no Toolkit, pois o pacote não conhece a política de autorização
da aplicação.

## Configuração que conecta o pacote ao Toolkit

O arquivo [`config/api-keys.php`](../config/api-keys.php) substitui a
configuração publicada pelo pacote. Ele é a fronteira entre o componente
genérico e as decisões desta aplicação.

### Owner e interface

O pacote recebe um alias na rota administrativa e o resolve pela configuração.
Aqui existe somente o alias `user`, mapeado para `App\\Models\\User`:

```php
// config/api-keys.php
'owners' => [
    'user' => App\\Models\\User::class,
],

'interface' => [
    'purposes' => [
        'integration' => 'Integração',
    ],
    'roles' => [
        'personal' => 'Pessoal',
        'directory' => 'Diretório',
    ],
],
```

Os valores à esquerda são persistidos na tabela; os textos à direita servem
apenas para a interface. Declarar `directory` nessa lista torna a opção
selecionável, mas **não** concede `users.read.any`: isso é decidido depois por
[`User::abilities()`](../app/Models/User.php).

### Credencial e autenticação

A mesma configuração define o formato da chave, o alias do middleware e onde o
middleware deixa a chave autenticada:

```php
// config/api-keys.php
'credential_prefix' => env('API_KEYS_CREDENTIAL_PREFIX', 'gpp'),
'public_prefix_length' => (int) env('API_KEYS_PUBLIC_PREFIX_LENGTH', 6),
'secret_bytes' => (int) env('API_KEYS_SECRET_BYTES', 32),

'middleware' => [
    'alias' => env('API_KEYS_MIDDLEWARE_ALIAS', 'uspdevApiKeys'),
    'request_attribute' => env('API_KEYS_REQUEST_ATTRIBUTE', 'apiKey'),
],
```

O fallback por query string também é configurado neste arquivo. Ele fica
habilitado por padrão no estado atual:

```php
'query_parameter' => [
    'enabled' => (bool) env('API_KEYS_QUERY_PARAMETER_ENABLED', true),
    'name' => env('API_KEYS_QUERY_PARAMETER_NAME', 'api_key'),
],
```

Em uma instalação que não necessite desse fallback, defina
`API_KEYS_QUERY_PARAMETER_ENABLED=false` no ambiente e limpe/recrie o cache
de configuração conforme o procedimento de deploy da aplicação.

## Persistência e formato da credencial

A migration cria `uspdev_api_keys` com owner polimórfico, metadados (`name`,
`purpose` e `role`), prefixo público único, hash do segredo, auditoria de uso,
expiração e revogação. O banco não armazena o segredo em texto puro.

Por padrão, uma credencial tem o formato:

```text
gpp_PREFIXO.SEGREDO
```

O prefixo `gpp`, o tamanho do prefixo público (6 caracteres) e o tamanho mínimo
do segredo (32 bytes aleatórios) são configuráveis em `config/api-keys.php` por
variáveis `API_KEYS_*`. Na criação, o pacote armazena apenas `secret_hash`; o
token completo é entregue uma vez. Na renovação, cria-se uma nova credencial e
a anterior é revogada em transação.

Antes de aceitar uma credencial, o pacote valida formato, prefixo, hash,
expiração e revogação. Em cada autenticação válida também registra contagem,
data/hora e IP do último uso.

A estrutura relevante está em
[`database/migrations/2026_07_13_000000_create_uspdev_api_keys_table.php`](../database/migrations/2026_07_13_000000_create_uspdev_api_keys_table.php):

```php
$table->morphs('owner');
$table->string('name');
$table->string('purpose')->index();
$table->string('role')->index();
$table->string('prefix')->unique();
$table->string('secret_hash');
$table->unsignedBigInteger('access_count')->default(0);
$table->timestamp('last_used_at')->nullable();
$table->timestamp('expires_at')->nullable()->index();
$table->timestamp('revoked_at')->nullable()->index();
```

Em termos práticos, `prefix` permite localizar a linha sem revelar o segredo;
`secret_hash` é conferido pelo pacote; e `owner_type` + `owner_id`, criados
por `morphs('owner')`, apontam para o usuário proprietário. Não exponha
`secret_hash`, nem espere recuperar o token depois da criação: a única ação
segura é renovar a chave, o que revoga a anterior.

## Papéis, abilities e autorização

Os valores de papel persistidos na chave são `personal` e `directory`. Eles não
são roles do Spatie: são papéis próprios da API Key. O método
`App\Models\User::abilities(string $role)` resolve suas abilities a cada uso:

| Papel da API Key | Abilities efetivas | Condição |
| --- | --- | --- |
| `personal` | `user.read` | Nenhuma condição adicional. |
| `directory` | `user.read`, `users.read.any` | O owner precisa poder `administrativa` ou `admin`. |
| Outro valor | Nenhuma | Não é reconhecido pela aplicação. |

`administrativa` é uma permissão local; `admin` é o Gate hierárquico usado pelo
`senhaunica-socialite`. Logo, roles do Spatie podem conceder permissões ao
usuário, mas não liberam endpoint algum diretamente. Cada controller consulta
uma ability da chave por `ApiKey::allows()`.

O cálculo dinâmico é intencional: uma chave `directory` existente perde
`users.read.any` assim que o owner perde `administrativa` e deixa de satisfazer
o Gate `admin`. A chave continua armazenada, mas a chamada ao diretório passa a
falhar com `403`.

A implementação está concentrada em
[`app/Models/User.php`](../app/Models/User.php):

```php
public function abilities(string $role): array
{
    return match ($role) {
        'personal' => ['user.read'],
        'directory' => ($this->can('administrativa') || $this->can('admin'))
            ? ['user.read', 'users.read.any']
            : [],
        default => [],
    };
}
```

O pacote chama esse método quando o controller usa `$apiKey->allows(...)`.
Não há uma cópia das abilities na linha da API Key. Essa escolha evita uma
revogação manual em massa: retirar a permissão do owner altera o resultado da
próxima requisição automaticamente.

## Emissão e gerenciamento web

A área `GET /keys` é registrada em
[`routes/web.php`](../routes/web.php), exige o middleware `auth` e chama
[`app/Http/Controllers/ApiKeysController.php`](../app/Http/Controllers/ApiKeysController.php).
O controller usa o usuário da sessão como owner e calcula o aviso da tela:

```php
$user = $request->user();

return view('api-keys.index', [
    'user' => $user,
    'canIssueDirectory' => $user->can('administrativa') || $user->can('admin'),
    'userEndpoint' => route('toolkit.api.current-user'),
    'usersEndpoint' => route('toolkit.api.users'),
]);
```

A view
[`resources/views/api-keys/partials/manager.blade.php`](../resources/views/api-keys/partials/manager.blade.php)
entrega esse owner e o alias ao componente do pacote:

```blade
<x-api-keys::manager :owner="$user" owner-alias="user" />
```

A configuração registra o alias `user` como owner e define o propósito
`integration`, além dos papéis Pessoal e Diretório.

As ações do pacote usam as rotas web abaixo. Elas recebem sessão, CSRF, `auth`
e o middleware da aplicação configurado em `api-keys.management.middleware`:

| Ação | Rota |
| --- | --- |
| Criar | `POST /api-keys/{ownerAlias}/{owner}/keys` |
| Revogar | `POST /api-keys/{ownerAlias}/{owner}/keys/{apiKey}/revoke` |
| Renovar | `POST /api-keys/{ownerAlias}/{owner}/keys/{apiKey}/renew` |

O pacote valida nome, propósito, papel e expiração, resolve o owner pelo alias
configurado e consulta a ability `manageApiKeys`. No Toolkit, essa ability
permite que o próprio owner gerencie suas chaves ou que um usuário com o Gate
`admin` as gerencie.

O middleware adicional é registrado na própria configuração, junto a `web` e
`auth`; logo, cobre as rotas que o pacote registra:

```php
// config/api-keys.php
'management' => [
    'middleware' => [
        'web',
        'auth',
        App\\Http\\Middleware\\EnsureApiKeyRoleCanBeIssued::class,
    ],
    'ability' => 'manageApiKeys',
],
```

A ability de gerenciamento é definida em
[`app/Providers/AuthServiceProvider.php`](../app/Providers/AuthServiceProvider.php).
Ela não avalia o papel solicitado; apenas decide se o usuário autenticado pode
administrar as chaves daquele owner:

```php
Gate::define('manageApiKeys', function (User $user, User $owner): bool {
    return $user->is($owner) || $user->can('admin');
});
```

Assim, um owner pode gerenciar as próprias chaves, e um administrador
hierárquico pode gerenciar as chaves de outro owner. A regra específica de
`directory` vem na próxima etapa, não neste Gate.

Há uma segunda proteção para o papel `directory`: o middleware
[`EnsureApiKeyRoleCanBeIssued`](../app/Http/Middleware/EnsureApiKeyRoleCanBeIssued.php)
intercepta somente criação e renovação com esse papel e exige que o **owner**
possa `administrativa` ou `admin`. Portanto, não basta poder administrar a
chave; o owner também precisa manter a autorização que justifica o escopo
global.

A condição que seleciona essas requisições é:

```php
if (
    ! $request->routeIs('api-keys.keys.store', 'api-keys.keys.renew')
    || $request->input('role') !== 'directory'
) {
    return $next($request);
}
```

Depois de resolver `ownerAlias` e `owner` da rota usando o mesmo mecanismo de
route model binding do Laravel, o middleware bloqueia somente o owner não
autorizado:

```php
if (
    $owner !== null
    && method_exists($owner, 'can')
    && ! $owner->can('administrativa')
    && ! $owner->can('admin')
) {
    // JSON: 403 + { message: ... }
    // formulário web: redirect back + session('api-keys.error')
}
```

Revogar uma chave não passa por esta regra, pois a revogação reduz acesso.
Para formulários web, a tentativa bloqueada volta à página anterior com a
mensagem `api-keys.error`; para requisições que esperam JSON, a resposta é
`403` com a mensagem de erro.

A tela exibida por
[`resources/views/api-keys/partials/manager.blade.php`](../resources/views/api-keys/partials/manager.blade.php)
avisa quando o usuário não pode emitir `directory`, mas ainda recebe as opções
do componente. Essa indicação visual não substitui o middleware: POSTs
forjados também são bloqueados.

## Autenticação das APIs

As APIs de negócio estão em
[`routes/api.php`](../routes/api.php), no grupo com o middleware
`uspdevApiKeys`:

```php
Route::middleware('uspdevApiKeys')->group(function (): void {
    Route::get('/toolkit/user', [UserApiController::class, 'current'])
        ->name('toolkit.api.current-user');

    Route::get('/toolkit/users', [UserApiController::class, 'index'])
        ->name('toolkit.api.users');
});
```

O alias `uspdevApiKeys` é registrado pelo service provider do pacote a partir
da chave `api-keys.middleware.alias` da configuração. O middleware executa
antes dos controllers e encerra a requisição com `401` se a credencial não for
autenticada.

O middleware extrai primeiro `Authorization: Bearer <API_KEY>`. Se não houver
Bearer e `api-keys.query_parameter.enabled` estiver habilitado, tenta
`?api_key=<API_KEY>` (ou o nome configurado). Após autenticar, coloca o modelo
da chave no atributo de request configurado, cujo padrão é `apiKey`.

O parâmetro de consulta existe como fallback de demonstração e é menos seguro:
URLs podem ser gravadas em históricos, logs e ferramentas de monitoramento.
Para integrações, use sempre o cabeçalho Bearer e desabilite o fallback quando
não for necessário.

## Endpoints disponibilizados

| Endpoint | Ability exigida | Resposta |
| --- | --- | --- |
| `GET /api/toolkit/user` | `user.read` | O owner da chave, com `id`, `name` e `email`, dentro de `data`. |
| `GET /api/toolkit/users` | `users.read.any` | Página de até 15 usuários, limitada a `id`, `name` e `email`. |

O endpoint `/user` ainda confirma que o owner da chave é um `User`. Já
`/users` é deliberadamente um escopo global: ele consulta a tabela de usuários,
não somente o owner. Por isso requer a ability elevada `users.read.any`.

Nos dois métodos de
[`app/Http/Controllers/Api/UserApiController.php`](../app/Http/Controllers/Api/UserApiController.php),
a chave é obtida pelo mesmo atributo configurável que o middleware preenche:

```php
$apiKey = $request->attributes->get(
    config('api-keys.middleware.request_attribute', 'apiKey')
);
```

A autorização e a resposta de `/user` são implementadas assim:

```php
abort_unless($apiKey?->owner instanceof User, Response::HTTP_FORBIDDEN);
abort_unless($apiKey->allows('user.read'), Response::HTTP_FORBIDDEN);

return response()->json([
    'data' => [
        'id' => $apiKey->owner->id,
        'name' => $apiKey->owner->name,
        'email' => $apiKey->owner->email,
    ],
]);
```

Para `/users`, a ability é diferente e a query seleciona explicitamente os
três campos que podem ser expostos:

```php
abort_unless($apiKey?->allows('users.read.any'), Response::HTTP_FORBIDDEN);

$users = User::query()
    ->select(['id', 'name', 'email'])
    ->paginate(15);

return response()->json($users);
```

Isso impede que `codpes`, roles, permissões, nível ou credenciais sejam
incluídos acidentalmente na resposta atual. A paginação segue o formato padrão
do Laravel, com `data`, links e metadados de página.

Exemplos:

```bash
# Lê o owner da chave personal ou directory
curl -H "Authorization: Bearer SUA_API_KEY" \
  "https://exemplo.br/api/toolkit/user"

# Lê a primeira página do diretório; requer directory autorizado
curl -H "Authorization: Bearer SUA_API_KEY" \
  "https://exemplo.br/api/toolkit/users?page=1"

# Fallback de demonstração — evitar em produção
curl "https://exemplo.br/api/toolkit/user?api_key=SUA_API_KEY"
```

A resposta de `/user` tem esta forma:

```json
{
  "data": {
    "id": 123,
    "name": "Maria da Silva",
    "email": "maria@example.test"
  }
}
```

Sem chave, com chave malformada, inválida, expirada ou revogada, o middleware
retorna `401`. Com chave autenticada, mas sem a ability exigida — inclusive se
o owner perdeu a autorização de `directory` — o controller retorna `403`.

## Documentação OpenAPI

Os atributos OpenAPI estão em
[`app/OpenApi/ApiKeySpecification.php`](../app/OpenApi/ApiKeySpecification.php)
e em
[`app/Http/Controllers/Api/UserApiController.php`](../app/Http/Controllers/Api/UserApiController.php).
Eles geram
[`docs/openapi/api-docs.json`](openapi/api-docs.json), servido pela interface
Swagger em `/api/documentation` e pelo JSON em `/docs`. A configuração do
gerador está em [`config/l5-swagger.php`](../config/l5-swagger.php).

A especificação declara dois esquemas de segurança: `bearerAuth`, preferido
para clientes reais, e `apiKeyQuery`, mantido para o fallback de demonstração.
Ela também documenta as respostas `401` e `403` de cada endpoint.

As rotas `/api-keys/...` não aparecem nessa especificação: são rotas de
administração via sessão web e CSRF, não endpoints autenticados por API Key.
Após alterar os atributos, regenere o artefato versionado:

```bash
php artisan l5-swagger:generate
```

Veja também [a documentação específica do Swagger](swagger.md) para detalhes
da interface e da URL-base da especificação.
