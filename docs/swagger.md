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

As rotas `/api-keys/...` não fazem parte da especificação: elas administram
chaves via sessão web, CSRF e autorização do usuário, não via API Key.

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
O segundo método foi mantido para testes locais; não deve ser usado em produção.

A URL-base da API no documento é derivada de `APP_URL` (ou pode ser definida
explicitamente por `L5_SWAGGER_CONST_HOST`). Dessa forma, instalações em um
subdiretório também geram chamadas corretas no Swagger UI.
