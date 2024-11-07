# Biblioteca Pessoal

## Usuario

### POST - Criar Usuario

Cria um novo usuario no banco de dados

URL: http://localhost:8000/registrar


```json
{
    "nome": "Novo Usuario",
    "senha": "senhaSegura123"
}
```

### POST - Login Usuario

Verifica se o nome e senha estao certas e retorna o ID

URL: http://localhost:8000/login

```json
{
    "nome": "Novo Usuario",
    "senha": "senhaSegura123"
}
```

### GET - Busca Usuario By Id

Retorna as informacoes do usuario

URL: http://localhost:8000/usuario

```json
{
    "id": 1
}
```

### PUT - Atualiza Usuario

Altera os valores do usuario com o id correspondente

URL: http://localhost:8000/atualizar


```json
{
    "id": 1,
    "nome": "usuario_atualizado",
    "senha": "nova_senha123"
}
```


### DELETE - Deletar Usuario

Deleta o usuario com base no id

URL: http://localhost:8000/deletar

```json
{
    "id": 14
}
```


## Livro

### POST - Criar Livro

Cria um livro novo

URL: http://localhost:8000/livro/registrar

```json
{
  "titulo": "O alquimista",
  "autor": "Paulo Coelho",
  "usuario_id": 1,
  "urlimagem": "https://teste.com/image.jpg",
  "comentario": "Livro muito bom sobre aventura",
  "nota": 5,
  "status": "Finalizado"
}
```

### PUT - Atualizar Livro

Atualiza as informacoes do livro

URL: http://localhost:8000/livro/atualizar

```json
{
  "id": 1,
  "titulo": "O Alquimista",
  "autor": "Paulo Coelho",
  "usuario_id": 1,
  "urlimagem": "https://teste.com/image.jpg",
  "comentario": "Livro sobre um Alquimista que vai em uma jornada",
  "nota": 5,
  "status": "Finalizado"
}
```

### DELETE - Deletar Livro

Deleta um livro com base no Id

URL: http://localhost:8000/livro/deletar

```json
{
  "id": 1
}
```

### GET - Pegar Todos os Livros Por Usuario Id

Envia um id de usuario e retorna todos os livros que ele possui na conta

URL: http://localhost:8000/livro

```json
{
  "usuario_id": 1
}
```


