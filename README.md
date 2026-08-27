# Toolkit

Sistema que permite testar algumas biblitecas do USPDev como o **replicado**, **laravel-usp-theme** e **senhaunica-fake**.

## Dependências

* PHP 8.3 pois usa laravel 12

## Instalação e configuração

Este é um projeto laravel e a configuração é similar a outros projetos que usam o framework.

* Faça o clone
* rode clone-projects.sh
* composer install
* copie e configure o .env
* rode a aplicação

## Funcionamento

Os projetos alvo são clonados em `uspdev` e, via composer, são linkados no `vendor/uspdev`.

Dessa forma podemos ajustá-los e testá-los diretamente nesse toolkit. Ao final commite e atualize os repositórios. 

### Replicado

O sistema irá procurar todas as classes no namespace Uspdev\Replicado.  
Em cada classe irá buscar os métodos, parâmetros e documentação (docblock).     
O sistema permitirá chamar o método e mostrará o resultado correspondente.


### Laravel-usp-Theme

O sistema tem uma view com a página de demo do theme.

### WSFoto

Permite consultar a foto correspondente.

### API Keys

Gerenciamento de chaves de API vinculadas ao usuário autenticado. A tela de
gerenciamento fica em `/keys` e utiliza o componente de gerenciamento da biblioteca,
mas com a interface do Toolkit.

Veja a [documentação detalhada de API Keys](docs/api-keys.md) para a configuração,
emissão, autenticação e autorização das chaves.

As chaves criadas nessa tela podem consumir:

| Papel | Abilities | Permissão-pai | Endpoints |
| --- | --- | --- | --- |
| `personal` | `user.read` | nenhuma | `GET /api/toolkit/user` |
| `directory` | `user.read`, `users.read.any` | `administrativa` ou Gate `admin` | `GET /api/toolkit/user` e `GET /api/toolkit/users` |

`GET /api/toolkit/user` retorna os dados do usuário proprietário da chave.
`GET /api/toolkit/users` retorna uma lista paginada de 15 usuários, somente com
`id`, `name` e `email`. O diretório é um escopo global concedido
deliberadamente pela ability `users.read.any`; ele não representa acesso
somente ao owner da chave.

Roles do Spatie concedem permissões da aplicação, mas a API decide o acesso
pelas abilities da API Key. O papel `directory` só mantém
`users.read.any` enquanto o owner possuir a permissão `administrativa` ou o Gate
hierárquico `admin`, verificados em cada uso.

A autenticação aceita `Authorization: Bearer SUA_API_KEY` ou o parâmetro
`?api_key=SUA_API_KEY`; para integrações, prefira Bearer, pois chaves em URLs
podem aparecer em históricos e logs. HTTP `401` indica falha de autenticação
(chave ausente, inválida, expirada ou revogada); HTTP `403` indica chave válida
sem a ability exigida ou sem a permissão-pai necessária.


### Senha única / Senha única faker

É necessário ter um BD para funcionar. Crie o BD e configure as credenciais no .env.


### WSBoleto

A Fazer.

## Como contribuir

Para adicionar uma nova biblioteca com métodos estáticos

* adicionar no `composer.json` a biblioteca na versão `dev-master`
* adicionar em `toolkit-projects.sh`
* adicionar em `app\models\Library.php`
