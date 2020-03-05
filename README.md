## Chalange Doc88 - Thallis Soares

### Instalação

Para gear a image do Docker basta executar no terminal e na pasta do projeto o seguinte comando:

```bash
docker build --tag=thallisphp/doc88-backend .
```

Após isso você já poderá executar os testes e iniciar a aplicação.

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
docker run --rm -it thallisphp/doc88-backend
```

----

### API

A API possui três recursos com métodos CRUDL

```
http://localhost:8000/api/clientes
http://localhost:8000/api/pasteis
http://localhost:8000/api/pedidos
```

Para executar os testes na API utilize a collection do Postman
