# API-RESTFUL-CORS-JWT-PHP-LARAVEL
HTTP, RESTful, Models, Migrations, Controllers, Rotas, Middlewares, Autenticação , Sessão, Validações e tratamento de erros.


# Tecnologia e Ferramentas
Backend - PHP 7.1+ Backend - Laravel Framework 5.7+ Backend - Servidor Apache 2.2 Backend - Banco de dados mysql 6.2+ Frontend - engine blade e JQuery Framework 1.9+

# Como Instalar
Faça uma copia do arquivo .env.example, e renomee para .env, em este arquivo você vai adicionar as seguintes configurações:

Banco de dados APP_KEY: variavel global de verificação da aplicação em base 64: 
$ php artisan key:generate;

Instalar as dependências do laravel com composer: 
$ composer install

Instalar as dependências do Vuejs com npm, lembre ter instalado o NODEJS: 
$ npm install

Crie o esquema do banco de dados no Postgresql com o comando:
$ php arstisan migrate

Agora podemos arrancar o servidor embutido do framework: 
$ php artisan serve
