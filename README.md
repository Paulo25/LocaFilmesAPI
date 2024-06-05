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


Documentação de Endpoints da API
Autenticação
Esses endpoints são usados para a autenticação e requerem o uso de JSON Web Token (JWT). O usuário deve estar logado para acessar essas rotas.

Login
Endpoint: POST /auth/login
Descrição: Realiza o login do usuário.
Parâmetros:
email: string, obrigatório
password: string, obrigatório
Resposta:
token: string, JWT para autenticação
Usuário Autenticado
Endpoint: GET /auth/me
Descrição: Retorna os detalhes do usuário autenticado.
Resposta:
user: objeto contendo os detalhes do usuário
Logout
Endpoint: GET /auth/logout
Descrição: Realiza o logout do usuário.
Resposta:
message: string, mensagem de sucesso
Refresh Token
Endpoint: GET /auth/refresh
Descrição: Atualiza o token JWT.
Resposta:
token: string, novo JWT
Informações do Token
Endpoint: GET /auth/info-token/{token}
Descrição: Retorna informações sobre o token JWT.
Parâmetros:
token: string, obrigatório
Resposta:
token_info: objeto contendo informações do token
Clientes
Esses endpoints são usados para gerenciar os clientes.

Listar Clientes
Endpoint: GET /clientes
Descrição: Retorna uma lista de todos os clientes.
Resposta:
clientes: array de objetos
Criar Cliente
Endpoint: POST /clientes
Descrição: Cria um novo cliente.
Parâmetros: Dados do cliente (JSON no corpo da requisição)
Resposta:
cliente: objeto do cliente criado
Mostrar Cliente
Endpoint: GET /clientes/{id}
Descrição: Retorna os detalhes de um cliente específico.
Parâmetros:
id: int, obrigatório
Resposta:
cliente: objeto do cliente
Atualizar Cliente
Endpoint: PUT /clientes/{id}
Descrição: Atualiza os dados de um cliente específico.
Parâmetros: Dados do cliente (JSON no corpo da requisição)
Resposta:
cliente: objeto do cliente atualizado
Excluir Cliente
Endpoint: DELETE /clientes/{id}
Descrição: Exclui um cliente específico.
Parâmetros:
id: int, obrigatório
Resposta:
message: string, mensagem de sucesso
Documento do Cliente
Endpoint: GET /clientes/{id}/documento
Descrição: Retorna os documentos de um cliente específico.
Parâmetros:
id: int, obrigatório
Resposta:
documentos: array de objetos
Telefone do Cliente
Endpoint: GET /clientes/{id}/telefone
Descrição: Retorna os telefones de um cliente específico.
Parâmetros:
id: int, obrigatório
Resposta:
telefones: array de objetos
Filme Alugado pelo Cliente
Endpoint: GET /clientes/{id}/filme-alugado
Descrição: Retorna os filmes alugados por um cliente específico.
Parâmetros:
id: int, obrigatório
Resposta:
filmes: array de objetos
Cliente Completo
Endpoint: GET /clientes/completo/{id}
Descrição: Retorna todas as informações de um cliente específico.
Parâmetros:
id: int, obrigatório
Resposta:
cliente: objeto contendo todas as informações do cliente
Documentos dos Clientes
Esses endpoints são usados para gerenciar os documentos dos clientes.

Listar Documentos
Endpoint: GET /documentos
Descrição: Retorna uma lista de todos os documentos.
Resposta:
documentos: array de objetos
Criar Documento
Endpoint: POST /documentos
Descrição: Cria um novo documento.
Parâmetros: Dados do documento (JSON no corpo da requisição)
Resposta:
documento: objeto do documento criado
Mostrar Documento
Endpoint: GET /documentos/{id}
Descrição: Retorna os detalhes de um documento específico.
Parâmetros:
id: int, obrigatório
Resposta:
documento: objeto do documento
Atualizar Documento
Endpoint: PUT /documentos/{id}
Descrição: Atualiza os dados de um documento específico.
Parâmetros: Dados do documento (JSON no corpo da requisição)
Resposta:
documento: objeto do documento atualizado
Excluir Documento
Endpoint: DELETE /documentos/{id}
Descrição: Exclui um documento específico.
Parâmetros:
id: int, obrigatório
Resposta:
message: string, mensagem de sucesso
Cliente do Documento
Endpoint: GET /documentos/{id}/cliente
Descrição: Retorna o cliente associado a um documento específico.
Parâmetros:
id: int, obrigatório
Resposta:
cliente: objeto do cliente
Telefones dos Clientes
Esses endpoints são usados para gerenciar os telefones dos clientes.

Listar Telefones
Endpoint: GET /telefones
Descrição: Retorna uma lista de todos os telefones.
Resposta:
telefones: array de objetos
Criar Telefone
Endpoint: POST /telefones
Descrição: Cria um novo telefone.
Parâmetros: Dados do telefone (JSON no corpo da requisição)
Resposta:
telefone: objeto do telefone criado
Mostrar Telefone
Endpoint: GET /telefones/{id}
Descrição: Retorna os detalhes de um telefone específico.
Parâmetros:
id: int, obrigatório
Resposta:
telefone: objeto do telefone
Atualizar Telefone
Endpoint: PUT /telefones/{id}
Descrição: Atualiza os dados de um telefone específico.
Parâmetros: Dados do telefone (JSON no corpo da requisição)
Resposta:
telefone: objeto do telefone atualizado
Excluir Telefone
Endpoint: DELETE /telefones/{id}
Descrição: Exclui um telefone específico.
Parâmetros:
id: int, obrigatório
Resposta:
message: string, mensagem de sucesso
Cliente do Telefone
Endpoint: GET /telefones/{id}/cliente
Descrição: Retorna o cliente associado a um telefone específico.
Parâmetros:
id: int, obrigatório
Resposta:
cliente: objeto do cliente
Filmes
Esses endpoints são usados para gerenciar os filmes.

Listar Filmes
Endpoint: GET /filmes
Descrição: Retorna uma lista de todos os filmes.
Resposta:
filmes: array de objetos
Criar Filme
Endpoint: POST /filmes
Descrição: Cria um novo filme.
Parâmetros: Dados do filme (JSON no corpo da requisição)
Resposta:
filme: objeto do filme criado
Mostrar Filme
Endpoint: GET /filmes/{id}
Descrição: Retorna os detalhes de um filme específico.
Parâmetros:
id: int, obrigatório
Resposta:
filme: objeto do filme
Atualizar Filme
Endpoint: PUT /filmes/{id}
Descrição: Atualiza os dados de um filme específico.
Parâmetros: Dados do filme (JSON no corpo da requisição)
Resposta:
filme: objeto do filme atualizado
Excluir Filme
Endpoint: DELETE /filmes/{id}
Descrição: Exclui um filme específico.
Parâmetros:
id: int, obrigatório
Resposta:
message: string, mensagem de sucesso


Agora podemos le o servidor embutido do framework: 
 ```shell
$ php artisan serve
```
