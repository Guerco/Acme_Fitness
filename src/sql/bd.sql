DROP DATABASE IF EXISTS acme_fitness; 
  
CREATE DATABASE acme_fitness; 
  
USE acme_fitness; 
  
-- Criando as Tabelas 
  
CREATE TABLE acme_fitness.categoria( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(50), 
    descricao TEXT 
)ENGINE=INNODB;  
  
CREATE TABLE acme_fitness.produto( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    nome varchar(50), 
    imagem_path varchar(200),
    descricao TEXT, 
    data_cadastro DATE, 
    categoria_id INT NOT NULL, 
    CONSTRAINT fk__produto_categoria FOREIGN KEY (categoria_id) REFERENCES categoria(id) ON DELETE RESTRICT 
)ENGINE=INNODB;  
  
CREATE TABLE acme_fitness.variacao( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    tamanho VARCHAR(20),  
    peso VARCHAR(20), 
    cor varchar(20), 
    preco DECIMAL(10,2), 
    estoque INT UNSIGNED, 
    produto_id INT NOT NULL, 
    CONSTRAINT fk__variacao_produto FOREIGN KEY(produto_id) REFERENCES produto(id) ON DELETE CASCADE 
)ENGINE=INNODB;  
  
CREATE TABLE acme_fitness.endereco( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    logradouro VARCHAR(50), 
    cidade VARCHAR(50), 
    bairro VARCHAR(50), 
    numero VARCHAR(10), 
    cep CHAR(9), 
    complemento VARCHAR(50) 
)ENGINE=INNODB;  
  
CREATE TABLE acme_fitness.cliente( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(50), 
    cpf CHAR(14), 
    data_nascimento DATE 
)ENGINE=INNODB;  
  
CREATE TABLE acme_fitness.venda( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    valor_total DECIMAL(10,2), 
    valor_frete DECIMAL(10,2), 
    descontos DECIMAL(10,2), 
    forma_pagamento ENUM('PIX', 'Boleto', 'Cartão (1x)'), 
    cliente_id INT, 
    endereco_id INT, 
    CONSTRAINT fk__venda_cliente FOREIGN KEY(cliente_id) REFERENCES cliente(id) ON DELETE SET NULL, 
    CONSTRAINT fk__venda_endereco FOREIGN KEY(endereco_id) REFERENCES endereco(id) ON DELETE SET NULL 
)ENGINE=INNODB;  
  
CREATE TABLE acme_fitness.variacao_venda( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    quantidade INT UNSIGNED, 
    variacao_id INT NOT NULL, 
    venda_id INT NOT NULL, 
    CONSTRAINT fk__variacao_venda_variacao FOREIGN KEY(variacao_id) REFERENCES variacao(id) ON DELETE RESTRICT, 
    CONSTRAINT fk__variacao_venda_venda FOREIGN KEY(venda_id) REFERENCES venda(id) ON DELETE CASCADE 
)ENGINE=INNODB;  
  
  
-- Inserindo exemplos de registros 

INSERT INTO acme_fitness.categoria(nome, descricao) VALUES  
('Aparelho','Aparelhos para realização de exercícios'), 
('Equipamento','Equipamentos para auxiliar em atividades.'),  
('Nutricinal','Produtos para suplementação alimentar'),  
('Roupa', 'Vestimentas fitness para fazer atividades'); 
  
INSERT INTO acme_fitness.produto(nome, imagem_path, descricao, data_cadastro, categoria_id) VALUES 
('Bicicleta Ergométrica', '/caminho/imagem.png', 'Bicicleta fixa para exercitar pedalagem', CURDATE(), 1), 
('Luva de Boxe', 'www.urldaimagem.com.br', 'Luva para prática de luta', '2024-03-10', 2),  
('Halter Emborrachado', '/caminho/imagem.jpeg', 'Peso para musculação', CURDATE(), 2), 
('Whey Morango', 'www.urldaimagem.com', 'Suplemento utilizado para auxiliar na construção muscular', '11/12/2024', 3), 
('Shorts Performance', '/caminho/imagem.png', 'Shorts para academia', CURDATE(), 4); 
  
INSERT INTO  acme_fitness.variacao(tamanho, cor, peso, preco, estoque, produto_id) VALUES 
('105x45x105 cm', 'Preto', '37 kg', 1299.90, 5, 1), 
('P', 'Vermelho', NULL, 50.49, 15, 2),   
('G', 'Preto', NULL, 55.49, 27, 2), 
('Pequeno', 'Cinza', '3 kg', 45.00, 3, 3),    
('Médio', 'Vermelho', '7 kg', 99.99, 7, 3),   
('Grande', 'Preto', '15 kg', 179.97, 11, 3),    
(NULL, NULL, '1 Kg', 99.00, 34, 4), 
(NULL, NULL, '2 Kg', 189.00, 34, 4), 
('P', 'Azul', NULL, 49.99, 15, 5),  
('M', 'Azul', NULL, 52.99, 7, 5),  
('G', 'Azul', NULL, 57.99, 9, 5); 
 
INSERT INTO acme_fitness.endereco(logradouro, cidade, bairro, numero, cep, complemento) VALUES  
('Avenida dos Coquinhos', 'Jamelândia', 'Coqueiral', '343', '123456-78', NULL ), 
('Rua General Marcelo Americo III', 'Pombalzinho do Norte', 'Parque Amaro', '64', '87654-321', NULL), 
('Alameda da Cadela', 'União Coquimbo do Sul', 'Rua da Água', '412', '13579-246', 'Bloco 1, Apto. 26'); 
 
INSERT INTO acme_fitness.cliente(nome, cpf, data_nascimento) VALUES 
('Gabriel Guerço', '123.456.789-01', '2004-08-14'), 
('Julimario da Silva Jr', '121.212.121-00', '1999-11-29'), 
('Pedro Enzzo Ferreira', '987.654.321-00', '1979-01-13'); 
 

INSERT INTO acme_fitness.venda (valor_total, valor_frete, descontos, forma_pagamento, cliente_id, endereco_id) VALUES 
(675.73, 10.00, 119.25, 'Boleto', 2, 2);  
INSERT INTO variacao_venda(quantidade, variacao_id, venda_id) VALUES 
(5, 7, 1), (2, 4, 1), (2, 5, 1); 
 
 
INSERT INTO acme_fitness.venda (valor_total, valor_frete, descontos, forma_pagamento, cliente_id, endereco_id) VALUES 
(1167.89, 10.00, 291.98, 'PIX', 3, 3);  
INSERT INTO variacao_venda(quantidade, variacao_id, venda_id) VALUES 
(1, 1, 2), (3, 9, 2); 