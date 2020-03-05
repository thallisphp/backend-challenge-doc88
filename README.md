## Challenge Doc88 - Thallis Soares

### Instalação

Para gear a image do Docker basta executar no terminal e na pasta do projeto o seguinte comando:

```bash
docker build --tag=thallisphp/doc88-backend .
```

Após isso você já poderá executar os testes e iniciar a aplicação.

**Atenção**. O banco de dados será resetado sempre que o campo de build for executado.

----

### Testes

Para executar os testes você tem duas opções

Testes rápido sem coverage:

```bash
docker run --rm -it thallisphp/doc88-backend phpunit --testdox --verbose
```

Testes um pouco mais lentos com coverage:

```bash
docker run --rm -it thallisphp/doc88-backend phpunit --testdox --verbose --coverage-text
```

Para iniciar o servidor da aplicação execute

```bash
docker run --rm -it -p 8000:8000 thallisphp/doc88-backend
```

Caso seja necessário executar algum comando do Laravel basta fazer da seguinte forma

```bash
docker run --rm -it thallisphp/doc88-backend php artisan migrate:refresh
```

----

### API

A API possui três recursos com métodos CRUDL

```
http://localhost:8000/api/clientes
http://localhost:8000/api/pasteis
http://localhost:8000/api/pedidos
```

Todas as rotas da API requerem autenticação Basic<br>
**Usuário:** teste@teste.com<br>
**Senha:** teste

Para executar os testes na API utilize a collection do Postman
