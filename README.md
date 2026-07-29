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

As chaves criadas nessa tela podem consumir `GET /api/toolkit/user`, que retorna
em JSON os dados do usuário proprietário da chave. A autenticação aceita o
cabeçalho `Authorization: Bearer SUA_API_KEY` ou o parâmetro
`?api_key=SUA_API_KEY`; para integrações, prefira o cabeçalho Bearer.


### Senha única / Senha única faker

É necessário ter um BD para funcionar. Crie o BD e configure as credenciais no .env.


### WSBoleto

A Fazer.

## Como contribuir

Para adicionar uma nova biblioteca com métodos estáticos

* adicionar no `composer.json` a biblioteca na versão `dev-master`
* adicionar em `toolkit-projects.sh`
* adicionar em `app\models\Library.php`
