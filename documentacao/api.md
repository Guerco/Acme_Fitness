# Informações sobre a API

## **Categorias**

- **GET** `/categorias` – Lista todas as categorias.
- **GET** `/categorias/{id}` – Busca uma categoria pelo ID.
- **POST** `/categorias` – Cria uma nova categoria.
- **PUT** `/categorias/{id}` – Atualiza uma categoria existente.
- **DELETE** `/categorias/{id}` – Deleta uma categoria.

### Body para  **POST** e **PUT**
``` 
{
    "nome" : "Nome da Categoria",
    "descricao" : "Descrição da Categoria" (opcional)
}
```

## **Clientes**

- **GET** `/clientes` – Lista todos os clientes.
- **GET** `/clientes/{id}` – Busca um cliente pelo ID.
- **POST** `/clientes` – Cria um novo cliente.
- **PUT** `/clientes/{id}` – Atualiza um cliente existente.
- **DELETE** `/clientes/{id}` – Deleta um cliente.

### Body para  **POST** e **PUT**
``` 
{
    "nome" : "Nome da Categoria",
    "cpf" : "XXX.XXX.XXX-XX",
    "data_nascimento" : "AAAA-MM-DD" 
}
``` 

## **Endereços**

- **GET** `/enderecos` – Lista todos os endereços.
- **GET** `/enderecos/{id}` – Busca um endereço pelo ID.
- **POST** `/enderecos` – Cria um novo endereço.
- **PUT** `/enderecos/{id}` – Atualiza um endereço existente.
- **DELETE** `/enderecos/{id}` – Deleta um endereço.

### Body para  **POST** e **PUT**
``` 
{
    "logradouro" : "Logradouro do Endereço",
    "cidade" : "Cidade do Endereço",
    "bairro" : "Bairro do Endereço",
    "numero" : "XXX",
    "cep" : "  "XXXXX-XXX",
    "complemento" : "Complemento do Endereço" (opcional)
}
``` 

## **Produtos**

- **GET** `/produtos` – Lista todos os produtos.
- **GET** `/produtos/{id}` – Busca um produto pelo ID.
- **POST** `/produtos` – Cria um novo produto.
- **PUT** `/produtos/{id}` – Atualiza um produto existente.
- **DELETE** `/produtos/{id}` – Deleta um produto.

### Body para  **POST** e **PUT**
``` 
{
    "nome" : "Nome do Produto",
    "imagem_path" : "Caminho para a imagem do Produto", (opcional)
    "descricao" : "Descrição do Produto", (opcional)
    "data_cadastro" : "AAAA-MM-DD", (opcional - caso não informado: data atual) 
    "categoria" : {
        "id" : XX
    }
}
``` 

## **Variações**

- **GET** `/variacoes` – Lista todas as variações.
- **GET** `/variacoes/{id}` – Busca uma variação pelo ID.
- **POST** `/variacoes` – Cria uma nova variação.
- **PUT** `/variacoes/{id}` – Atualiza uma variação existente.
- **DELETE** `/variacoes/{id}` – Deleta uma variação.

### Body para  **POST** e **PUT**
``` 
{
    "tamanho" : "Tamanho da Variação", (opcional)
    "peso" : "Peso da Variação", (opcional)
    "cor" : "Cor da Variação", (opcional)
    "preco" : XX.XX,  
    "estoque" : XX,  
    "prodito" : {
        "id" : XX
    }
}
``` 

## **Vendas**

- **GET** `/vendas` – Lista todas as vendas.
- **GET** `/vendas/{id}` – Busca uma venda pelo ID.
- **POST** `/vendas` – Cria uma nova venda.
- **DELETE** `/vendas/{id}` – Deleta uma venda.

### Body para  **POST** e **PUT**
``` 
{
    "descontos" : XX.XX, (opcional)
    "forma_pagamento" : "PIX" OU "Boleto" OU  "Cartão", (opcional) 
    "cliente" : {
        "id" : XX
    },
    "endereco" : {
        "id" : XX
    },
    "itens" : [
        {
            "quantidade" : XX,
            "variacao" : {
                "id" : XX
            }
        }
    ]
}
``` 
