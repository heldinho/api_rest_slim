FORMAT: 1A

### Fazer clonagem do repositório para a pasta raiz do apache estrutura usada (xampp ou wamp).

### Segue arquivo api_teste.sql para a base de dados de efetuar o teste.

### Teste via Cliente - onde é só acessar o url e verificar os resultados.

## Teste via terminal

### Users [/users]

#### Listar todos os users [GET /users]

php curl -i -X GET -H 'Content-Type: application/json' -d 'http://localhost/exemplo/get.php/users'

#### Listar user com a {$id} [GET /user/{$id}]

php curl -i -X GET -H 'Content-Type: application/json' -d
'{
    "id":"1",
    "name": "Helder Passos",
    "email": "helder@teste.com",
    "telefone": "970707070",
    "address": "Rua Teste, 35"
}'
'http://localhost/exemplo/get.php/user/{$id}'

#### Criar um novo user [POST /users]

php curl -i -X POST -H 'Content-Type: application/json' -d
'{
    "name": "Helder Passos",
    "email": "helder@teste.com",
    "telefone": "970707070",
    "address": "Rua Teste, 35"
}'
'http://localhost/exemplo/get.php/users'

#### Editar o com user [PUT /users/{$id}]

php curl -i -X PUT -H 'Content-Type: application/json' -d
'{
	"id": "1"
    "name": "Helder Passos",
    "email": "helder@teste.com",
    "telefone": "970707070",
    "address": "Rua Teste, 35"
}'
'http://localhost/exemplo/get.php/users/{$id}'

#### Deletar o user pelo {$id} [DELETE /user/{$id}]

php curl -i -X DELETE -H 'Content-Type: application/json' -d
'{
    "id":"1"
}'
'http://localhost/exemplo/get.php/user/{$id}'