# API-RESTFUL-CORS-JWT-PHP-LARAVEL
HTTP, RESTful, Models, Migrations, Controllers, Rotas, Middlewares, Autenticação , Sessão, Validações e tratamento de erros.


# Tecnologia e Ferramentas
Backend - PHP 7.1+ Backend - Laravel Framework 5.7+ Backend - Servidor Apache 2.2 Backend - Banco de dados mysql 6.2+ Frontend - engine blade e JQuery Framework 1.9+

# Como Instalar

configuração do .env:
 ```shell
Faça uma copia do arquivo .env.example, e renomear para .env, neste arquivo você vai adicionar as configurações.
```

Banco de dados APP_KEY: variavel global de verificação da aplicação em base 64:
 ```shell 
$ php artisan key:generate;
```

Instalar as dependências do laravel com composer: 
 ```shell
$ composer install
```

Instalar as dependências do js em node_modules com npm, lembre ter instalado o NODEJS: 
 ```shell
$ npm install
```

Publique as traduções para o português: 
 ```shell
$ php artisan vendor:publish --tag=laravel-pt-br-localization
```

Altere Linha 83 do arquivo config/app.php para:
 ```shell
'locale' => 'pt_BR'
```

Crie o esquema do banco de dados no Postgresql e popule algumas tabelas com semeador com o comando:
 ```shell
$ php arstisan migrate --seed
```

Opcional, popule algumas tabela executando o comando:
 ```shell
$ php artisan db:seed 
```

Configuração da politica de CORS - Os padrões estão definidos config/cors.php. Publique a configuração para copiar o arquivo para sua própria configuração:
```shell
php artisan vendor:publish --tag="cors"
```

Para permitir o CORS para todas as suas rotas, adicione o HandleCorsmiddleware na $middlewarepropriedade da app/Http/Kernel.phpclasse:
```shell
protected $middleware = [\Fruitcake\Cors\HandleCors::class];
```

Agora atualize a configuração para definir os caminhos nos quais você deseja executar o serviço CORS:
```shell
'paths' => ['api/*'],
```
O pacote do compositor jwt-auth possui um arquivo de configuração que você pode publicar,
um novo arquivo de configuração é gerado em config / jwt.php.:
```shell
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Gerar chave secreta, Isso atualizará seu .envarquivo com algo comoJWT_SECRET=foobar:
```shell
php artisan jwt:secret
```

Agora podemos le o servidor embutido do framework: 
 ```shell
$ php artisan serve
```
