# Documentação Swagger / OpenAPI

## Decisão

Foi usado o pacote `darkaonline/l5-swagger` como integração com o Laravel. Ele registra a
interface Swagger UI, as rotas que servem a especificação e o comando de
geração. O pacote usa `zircote/swagger-php` internamente, que lê os atributos
OpenAPI em PHP e gera a especificação.

## Escopo

A documentação inclui somente as rotas de integração autenticadas pelo
middleware `uspdevApiKeys`. No momento, isso corresponde a:

- `GET /api/toolkit/user`
- `GET /api/toolkit/users`

As rotas `/api-keys/...` não fazem parte da especificação: elas administram
chaves via sessão web, CSRF e autorização do usuário, não via API Key.

## Papéis e autorização

As opções disponíveis na tela `/keys` formam a seguinte matriz:

| Papel da API Key | Abilities | Permissão-pai | Endpoints |
| --- | --- | --- | --- |
| `personal` | `user.read` | nenhuma | `/api/toolkit/user` |
| `directory` | `user.read`, `users.read.any` | `administrativa` ou Gate `admin` | `/api/toolkit/user`, `/api/toolkit/users` |

Roles do Spatie concedem permissões da aplicação, mas não autorizam uma rota
da API diretamente. Cada endpoint consulta a ability da API Key; a ability
`users.read.any` também depende dinamicamente da permissão `administrativa` ou
do Gate hierárquico `admin` do owner. O diretório é um escopo global deliberado: ele lista usuários do
sistema, não somente o owner da chave.

HTTP `401` significa que a autenticação falhou (chave ausente, inválida,
expirada ou revogada). HTTP `403` significa que a chave foi autenticada, mas
não possui a ability exigida — inclusive quando a autorização elevada foi
removida depois da emissão da chave.

## Artefatos e uso

- Swagger UI: `/api/documentation`
- JSON servido pela aplicação: `/docs`
- Arquivo versionado: `docs/openapi/api-docs.json`

Após alterar os atributos em `app/OpenApi` ou nos controllers documentados,
regenere o JSON:

```bash
php artisan l5-swagger:generate
```

O Swagger UI permite autenticar pelo cabeçalho Bearer ou por `?api_key=`.
Prefira Bearer: chaves em URLs podem aparecer em históricos, logs e ferramentas
de monitoramento. O segundo método foi mantido somente para testes locais e
demonstração; não deve ser usado em produção.

A URL-base da API no documento é derivada de `APP_URL` (ou pode ser definida
explicitamente por `L5_SWAGGER_CONST_HOST`). Dessa forma, instalações em um
subdiretório também geram chamadas corretas no Swagger UI.
