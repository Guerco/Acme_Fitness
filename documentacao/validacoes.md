
# Validações implementadas em cada classe

## Categoria
1. Checa se o id é inteiro e não negativo
2. Checa se o nome foi preenchido e se possui no máximo 50 caracteres

##  Cliente
1. Checa se o id é inteiro e não negativo
2. Checa se o nome foi preenchido e se possui no máximo 50 caracteres
3. Checa se o cpf foi preenchido e se segue o formato XXX.XXX.XXX-XX
4. Checa se a data de nascimento foi preenchida, se segue o formato AAAA-MM-DD, e se é uma data existente

## Endereco
1. Checa se o id é inteiro e não negativo
2. Checa se o logradouo foi preenchido e se possui no máximo 50 caracteres
3. Checa se o número foi preenchido e se possui no máximo 50 caracteres
4. Checa se o bairro foi preenchido e se possui no máximo 50 caracteres
5. Checa se a cidade foi preenchida e se possui no máximo 50 caracteres
6. Checa se o complemento, caso preenchido, possui no máximo 50 caracteres
7. Checa se o cep foi preenchido e se segue o formato XXXXX-XXX

## Produto 
1. Checa se o id é inteiro e não negativo
2. Checa se o nome foi preenchido e se possui no máximo 50 caracteres
3. Checa se o caminho da imagem, caso preenchido,  possui no máximo 200 caracteres
4. Checa se a categoria foi preenchida e se seu id é inteiro e não negativo
5. Checa se a data de cadastro foi preenchida, se segue o formato AAAA-MM-DD, e se é uma data existente

## Variacao
1. Checa se o id é inteiro e não negativo
2. Checa se o tamanho, caso preenchido, possui no máximo 20 caracteres
3. Checa se o peso, caso preenchido, possui no máximo 20 caracteres
4. Checa se a cor, caso atribuida, possui no máximo 20 caracteres
5. Checa se o preço foi preenchido e se é positivo
6. Checa se o estoque foi preenchido e se seu valor é inteiro e não negativo
7. Checa se o produto foi preenchido e se seu id é inteiro e não negativo

## Venda
1. Checa se o id é inteiro e não negativo
2. Checa se o valor dos descontos, caso preenchido, é um número não negativo
3. Checa se a forma de pagamento foi preenchida e se seu valor é válido (PIX, Boleto ou Cartão (1x))
4. Checa se o cliente foi preenchido e se seu id é inteiro e não negativo
5. Checa se o endereço foi preenchido e se seu id é inteiro e não negativo
6. Checa se a lista de itens não está vazia
7. Checa se a quantidade do item selecionado é positiva
8. Checa se o item selecionado possui estoque o suficiente













