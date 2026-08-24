<?php

/*
|--------------------------------------------------------------------------
| Configuração da interface de API Keys
|--------------------------------------------------------------------------
| Este arquivo sobrescreve a configuração publicada pelo package para esta
| aplicação hospedeira.
*/

return [
    // Models que podem possuir API Keys. A chave do array é o alias usado
    // pelas rotas administrativas do package; o valor é a classe do owner.
    // Neste projeto, as chaves pertencem a usuários.
    'owners' => [
        'user' => App\Models\User::class,
    ],

    // Prefixo das rotas administrativas fornecidas pelo package, como as
    // rotas de criação, renovação e revogação de uma chave.
    'prefix' => 'api-keys',

    // Prefixo textual de toda credencial emitida. O formato público padrão é
    // gpp_PREFIXO.SEGREDO. Altere-o apenas se houver necessidade de
    // distinguir as chaves desta aplicação de outras credenciais.
    'credential_prefix' => env('API_KEYS_CREDENTIAL_PREFIX', 'gpp'),

    // Quantidade de caracteres do prefixo público, que identifica a chave no
    // banco sem revelar o segredo. O prefixo não autentica a credencial.
    'public_prefix_length' => (int) env('API_KEYS_PUBLIC_PREFIX_LENGTH', 6),

    // Quantidade mínima de bytes aleatórios usados para gerar o segredo. O
    // package armazena somente o hash; o segredo completo é exibido uma vez.
    'secret_bytes' => (int) env('API_KEYS_SECRET_BYTES', 32),

    // Integração entre o middleware do package e as rotas da aplicação.
    'middleware' => [
        // Alias usado nas rotas protegidas, por exemplo:
        // Route::middleware('uspdevApiKeys')->group(...).
        'alias' => env('API_KEYS_MIDDLEWARE_ALIAS', 'uspdevApiKeys'),

        // Nome do atributo adicionado ao Request com a API Key autenticada.
        // Controllers podem obter a chave por $request->attributes->get(...).
        'request_attribute' => env('API_KEYS_REQUEST_ATTRIBUTE', 'apiKey'),
    ],

    'query_parameter' => [
        // Permite autenticar também por ?api_key=... para integrações que não
        // conseguem enviar Authorization: Bearer. Desabilite em produção
        // quando não houver necessidade: URLs podem aparecer em logs,
        // históricos do navegador e ferramentas de monitoramento.
        'enabled' => (bool) env('API_KEYS_QUERY_PARAMETER_ENABLED', true),

        // Nome do parâmetro aceito quando o fallback por query string está
        // habilitado.
        'name' => env('API_KEYS_QUERY_PARAMETER_NAME', 'api_key'),
    ],

    // Proteção das rotas administrativas do package. Estes middlewares são
    // aplicados às operações de gerenciamento da interface, não às APIs de
    // negócio protegidas por API Key.
    'management' => [
        // 'web' habilita sessão/CSRF e 'auth' exige usuário autenticado.
        'middleware' => [
            'web',
            'auth',
            // A aplicação valida a permissão-pai antes de emitir directory;
            // o package conhece os papéis, mas não conhece as permissões locais.
            App\Http\Middleware\EnsureApiKeyRoleCanBeIssued::class,
        ],

        // Ability do Laravel usada para decidir quem pode gerenciar as chaves
        // de cada owner. A regra efetiva fica na aplicação hospedeira.
        'ability' => 'manageApiKeys',
    ],

    // Valores exibidos nos campos de seleção do componente Blade do package.
    // Os valores à esquerda são gravados na API Key; os textos à direita são
    // apresentados ao usuário.
    'interface' => [
        // Finalidade declarada da chave. A finalidade é metadado da credencial
        // e pode ser usada pela aplicação para organizar integrações.
        'purposes' => [
            'integration' => 'Integração',
        ],

        // Papel solicitado no momento da emissão. A configuração disponibiliza
        // opções na interface, mas não define acesso sozinha: User::abilities()
        // resolve as abilities e verifica dinamicamente a permissão
        // administrativa para directory.
        'roles' => [
            'personal' => 'Pessoal',
            'directory' => 'Diretório',
        ],
    ],
];
