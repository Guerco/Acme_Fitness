# Acme_Fitness
Projeto realizado como desafio, baseado em um Mini Mundo onde uma empresa de produtos fitness procura desenvolver uma API para seu sistema de E-Commerce.

---

### Projeto desenvolvido em:
- PHP 8,2,4
- MYSQL

---

## Estrutura do Projeto
**/documentacao** - documentação do projeto  
 **/src** - código fonte principal do projeto  
    **/controller** - gerenciadores de requisições e interação entre regras de negócio e dados  
    **/dao** - objetos de acesso à dados e interação com o banco  
    **/model** - classes e lógica de negócio  
    **/sql** - arquivos de banco de dados  
    **conexao.php** - arquivo de configuração da conexão com o banco de dados  
 **/index.php** - entrada principal da api  
 **/rotas.php** - tratamento das rotas de recursos da api  

## Configuração do Ambiente  
- Configure o arquivo `conexao.php` com as informações do banco.  
- Execute o [script sql](/src/sql/bd.sql) no seu SGBD.  
- Inicie o servidor local para acessar o projeto.


---

## Estrutura do Banco de Dados
![Diagrama de Entidades](/documentacao/diagrama_entidades.png)

A empresa fictícia possui produtos fitness de diversas categorias, desde suplementação alimentar até aparelhos de ginástica
Cada produto pertence a uma categoria, e possui diversass variações que podem diferir em tamanho, peso e cor, consequentemente também no preço
As variações são atribuidas como itens nas vendas em diferentes quantidades
As vendas são registradas com um cliente e um endereço 

---

## API
Para informações sobre o uso da API consulte a [documentação da api](/documentacao/api.md)

---

## Validação de Dados
Para informações sobre a validação dos dados consulte a [documentação da validação](/documentacao/validacoes.md)

---
