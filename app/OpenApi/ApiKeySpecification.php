<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;


// Arquivo central de metadados da documentação OpenAPI.
// Ele não é chamado diretamente por nenhuma rota nem executa lógica da API.
// O zircote/swagger-php, acionado pelo comando de gerar documentação,
// varre esse arquivo e lê seus atributos PHP:

#[OA\Info(
    version: '1.0.0',
    title: 'Toolkit API',
    description: 'API de integração do Toolkit autenticada por API Key. Papéis disponíveis: personal concede user.read; directory concede user.read e users.read.any somente enquanto o owner possuir a permissão-pai administrativa. Roles do Spatie concedem permissões da aplicação, mas os endpoints autorizam pela ability da API Key. HTTP 401 indica falha de autenticação; HTTP 403 indica uma chave autenticada sem a ability exigida.'
)]
/*
 * A constante é preenchida pelo L5 Swagger a partir de APP_URL. Assim a URL
 * mantém o subdiretório da aplicação quando ela não está publicada na raiz do
 * domínio
 */
#[OA\Server(url: L5_SWAGGER_CONST_HOST, description: 'Instância atual da aplicação')]
#[OA\Tag(
    name: 'API Keys',
    description: 'Operações autenticadas por uma API Key do Toolkit.'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'API Key',
    description: 'Informe somente a API Key; o Swagger UI adiciona o prefixo Bearer.'
)]
#[OA\SecurityScheme(
    securityScheme: 'apiKeyQuery',
    type: 'apiKey',
    name: 'api_key',
    in: 'query',
    description: 'Alternativa para testes locais. Evite em produção porque URLs podem aparecer em logs e históricos.'
)]
#[OA\Schema(
    schema: 'CurrentUserResponse',
    required: ['data'],
    properties: [
        new OA\Property(
            property: 'data',
            type: 'object',
            required: ['id', 'name', 'email'],
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 123),
                new OA\Property(property: 'name', type: 'string', example: 'Maria Silva'),
                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'maria@usp.br'),
            ]
        ),
    ]
)]
#[OA\Schema(
    schema: 'DirectoryUser',
    required: ['id', 'name', 'email'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 123),
        new OA\Property(property: 'name', type: 'string', example: 'Maria Silva'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'maria@usp.br'),
    ]
)]
#[OA\Schema(
    schema: 'DirectoryUsersResponse',
    required: ['current_page', 'data', 'per_page', 'total'],
    properties: [
        new OA\Property(property: 'current_page', type: 'integer', example: 1),
        new OA\Property(
            property: 'data',
            type: 'array',
            maxItems: 15,
            items: new OA\Items(ref: '#/components/schemas/DirectoryUser')
        ),
        new OA\Property(property: 'per_page', type: 'integer', example: 15),
        new OA\Property(property: 'total', type: 'integer', example: 42),
    ]
)]
#[OA\Schema(
    schema: 'ApiKeyRole',
    type: 'string',
    enum: ['personal', 'directory'],
    description: 'personal concede user.read. directory concede user.read e users.read.any enquanto o owner possuir administrativa.'
)]
#[OA\Schema(
    schema: 'ErrorResponse',
    required: ['message'],
    properties: [
        new OA\Property(property: 'message', type: 'string'),
    ]
)]
final class ApiKeySpecification {}
