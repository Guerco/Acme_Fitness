# Acme_Fitness
Projeto realizado como desafio, baseado em um Mini Mundo onde uma empresa de produtos fitness procura desenvolver uma API para seu sistema de E-Commerce.

---

### Projeto desenvolvido com:
- *PHP 8.2.4*
- *MySQL*
- *PHPUnit 11.5.1*

---

## Estrutura do Projeto

| **Diretório/Arquivo**                 | **Descrição**                                                                |
|---------------------------------------|------------------------------------------------------------------------------|
| [/src](/src)                          | Código fonte principal do projeto                                            |
| [/controller](/src/controller/)       | Gerenciadores de requisições e interação entre regras de negócio e dados     |
| [/dao](/src/dao)                      | Objetos de acesso à dados e interação com o banco                            |
| [/model](/src/model)                  | Classes e lógica de negócio                                                  |
| [/sql](/src/sql)                      | Arquivos de banco de dados                                                   |
| [/documentacao](/documentacao)        | Documentação do projeto                                                      |
| [/rotas](/rotas)                      | Tratamento das rotas de recursos da API                                      |
| [/testes](/testes)                    | Dependências PHPUnit e casos de teste                                        |
| [/conexao.php](/src/conexao.php)      | Arquivo de configuração da conexão com o banco de dados                      |
| [/phpunit.xml](/phpunit.xml)          | Arquivo de configuração do PHPUnit                                           |
| [/index.php](/index.php)              | Arquivo de entrada da API                                                    |

## Configuração do Ambiente  
- Execute o [script sql](/src/sql/bd.sql) no seu SGBD.  
- Configure o arquivo de [conexão](src/conexao.php) com as informações do banco.  
- Inicie o servidor local para acessar o projeto.

---

## Estrutura do Banco de Dados
![Diagrama de Entidades](/documentacao/diagrama_entidades.png)

A empresa fictícia oferece uma variedade de produtos fitness, que abrangem desde suplementos alimentares até equipamentos de ginástica. Cada produto está associado a uma categoria específica e pode apresentar diferentes variações, que diferem em tamanho, peso e cor, refletindo, por sua vez, em variações de preço. Essas variações são incluídas como itens nas vendas, podendo ser registradas em diferentes quantidades. As vendas são processadas com a vinculação de um cliente e um endereço.

---

## API
Para informações sobre o uso da API, consulte a [documentação da API](/documentacao/api.md).

- *[Coleção de Requisições](/documentacao/request_collection_Insomnia.json)*

---

## Validação de Dados
Para informações sobre a validação dos dados, consulte a [documentação da validação](/documentacao/validacoes.md).

---

## Testes
Para informações sobre os casos de testes, consulte a [documentação de testes](/documentacao/testes.md).

---

---

Veja também: [versão desenvolvida em framework laravel](https://github.com/Guerco/Acme_Fitness_Laravel)
---