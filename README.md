# Test PJBank
### Requisitos do sistema:
  - PHP ^7.0
  - MySQL 5.7
 
 Ou Docker instalado.

# Instalação

Clone o repositório

```
git clone https://github.com/danilocolasso/pjbank-api.git
cd pjbank-api
```

O Código fonte do projeto encontra-se na pasta /application.

### Docker - Configuração de ambiente (opcional)

  - Baixe e instale o [Docker](https://www.docker.com/products/docker-desktop). Caso não possua uma conta, [realize o cadastro](https://hub.docker.com/signup), será necessário.
  - Na pasta */docker*  encontram-se os arquivos para executar um container com toda a configuração necessária para o projeto.
  - Após instalado e configurado, certifique-se de que está na pasta */docker* e execute o seguinte comando:

```
docker-compose up -d
```
Pronto, seu ambiente php está configurado!
Para acessar o projeto basta ir até [localhost](http://localhost). Mas antes precisamos configurar o banco de dados e algumas dependências...

### Dependências
Para gerenciamento das dependências, utilizaremos o [Composer](https://getcomposer.org/). Caso não o tenha instalado, baixe e configure-o seguindo [estas instruções](https://getcomposer.org/doc/00-intro.md).
Após instalado, basta entrar na pasta do projeto (/application) e executar:
```
composer install
```
Pronto! O Composer irá instalar todas as dependências do projeto.

### Banco de Dados

Caso não possua nenhuma ferramenta para acesso ao MySQL, pode-se utilizar o container com o PhpMyAdmin. Basta acessar [localhost:8080](http://localhost:8080).

Crie uma base com o nome "store".

Agora precisamos criar a estrutura e popular o banco. Para isso, caso tenha optado pelo ambiente Docker, execute o seguinte comando:
```
docker-compose exec php /bin/bash
```

Agora, vamos de fato criar a estrutura. Na pasta do projeto (/application) e execute:
 ```
 php artisan migrate
 ```

Feito! E para popular o banco, execute:
```
php artisan db:seed
```

Com isso, serão gerados alguns produtos aleatórios e, um cliente *hardcoded* em um Seeder.

Agora basta configurar seu banco de dados no arquivo *.env*, que encontra-se na raiz da pasta do projeto (/application). Lá encontra-se também a configuração do e-mail e, a URL/Token utilizados para acessar a API do PJBank.
###### Tudo certo, o projeto está pronto para ser executado. ;)

### Executando o projeto
Utilize de alguma ferramenta para envio de requisições, como o [Postman](https://www.getpostman.com/).
As rotas disponíveis são:

- [GET] Listagem de Produtos: [localhost/api/products](http://localhost/api/products)
- [GET] Exibição de UM Produto: [localhost/api/product/1](http://localhost/api/product/1) (o último parâmetro é o id do produto desejado)
- [POST] Realizar um pedido: [localhost/api/order](http://localhost/api/order) com os produtos como parâmetro:
    - e.g. 
    ```php
      [ products => [id => 1, quantity => 3], [id => 5, quantity => 1], ... ]
    ```
Ps.: TODAS as rotas exigem um header "Api-Token". O mesmo encontra-se no cadastro do Cliente, no banco de dados.


### Tests
Para executar os tests, na pasta raiz do projeto execute:
```
vendor/bin/phpunit
```

### Explicando o Projeto
Tecnologias utilizadas:

  - Composer para gerenciamento de dependências.
  - Lumen como framework base (Symfony ou Laravel apenas para uma api seria exagero).
  - Docker como ambiente.
  - Autenticação feita de forma simples, apenas um middleware validando um header "Api-Token". Mas poderia ser feito com o Auth0, por exemplo.

##### To do

 - Front-end.
 - Terminar implementação do e-mail.
 - Paginação.
 - Authenticação nos tests (não os alterei após adicionar autenticação).
 - Utilizar Auth0 para autenticação.
 - Gerar documentação (PHPDoc).
 - Cache (Redis).