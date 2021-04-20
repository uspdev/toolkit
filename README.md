# Toolkit

Sistema que permite testar algumas biblitecas do USPDev como o **replicado**, **laravel-usp-theme** e **senhaunica-fake**.

## Instalação e configuração

Este é um projeto laravel e a configuração é similar a outros projetos que usam o framework.

* Faça o clone
* composer install
* copie e configure o .env
* rode a aplicação

## Funcionamento

Os projetos alvo são clonados em `uspdev-projects` e linkados no `vendor/uspdev`.

Dessa forma podemos ajustá-los e testá-los diretamente nesse toolkit. Ao final commite e atualize os repositórios. 

### Replicado

O sistema irá procurar todas as classes no namespace Uspdev\Replicado.  
Em cada classe irá buscar os métodos, parâmetros e documentação (docblock).     
O sistema permitirá chamar o método e mostrará o resultado correspondente.


### Laravel-usp-Theme

O sistema tem uma view com a página de demo do theme.

### WSFoto

Permite consultar a foto correspondente.


### Senha única / Senha única faker

É necessário ter um BD para funcionar. Crie o BD e configure as credenciais no .env.


### WSBoleto

A Fazer.

## Como contribuir

Para adicionar uma nova biblioteca com métodos estáticos

* adicionar no `composer.json` a biblioteca na versão `dev-master`
* adicionar em `toolkit-projects.sh`
* adicionar em `app\models\Library.php`