<?php

class VariacaoDao {

    public function __construct (
        private PDO $pdo
    ){}

    public function buscarTudo() {
        $sql = <<< 'SQL'
            SELECT 
                v.id, 
                v.tamanho, 
                v.peso, 
                v.cor, 
                v.preco, 
                v.estoque,
                
                p.id AS produto_id, 
                p.nome AS produto_nome, 
                p.imagem_path AS produto_imagem_path, 
                p.descricao AS produto_descricao, 
                p.data_cadastro AS produto_data_cadastro, 
                
                c.id AS produto_categoria_id, 
                c.nome AS produto_categoria_nome, 
                c.descricao AS produto_categoria_descricao
            FROM
                variacao v
            JOIN 
                produto p ON p.id = v.produto_id
            JOIN
                categoria c ON c.id = p.categoria_id
        SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $variacoes = [];

        foreach($stmt as $d) {
            $variacoes [] = [
                'id' => $d['id'],
                'tamanho' => $d['tamanho'],
                'peso' => $d['peso'],
                'cor' => $d['cor'],
                'preco' => $d['preco'],
                'estoque' => $d['estoque'],
                
                'produto' => [
                    'id' => $d['produto_id'],
                    'nome' => $d['produto_nome'],
                    'imagem_path' => $d['produto_imagem_path'],
                    'descricao' => $d['produto_descricao'],
                    'data_cadastro' => $d['produto_data_cadastro'],
                    
                    'categoria' => [
                        'id' => $d['produto_categoria_id'],
                        'nome' => $d['produto_categoria_nome'],
                        'descricao' => $d['produto_categoria_descricao']
                    ]
                ]
            ];

        }
        return $variacoes;
    }

    public function buscarPeloId($id) {
        
        $sql = <<< 'SQL'
            SELECT 
                v.id, 
                v.tamanho, 
                v.peso, 
                v.cor, 
                v.preco, 
                v.estoque,
                
                p.id AS produto_id, 
                p.nome AS produto_nome, 
                p.imagem_path AS produto_imagem_path, 
                p.descricao AS produto_descricao, 
                p.data_cadastro AS produto_data_cadastro, 
                
                c.id AS produto_categoria_id, 
                c.nome AS produto_categoria_nome, 
                c.descricao AS produto_categoria_descricao
            FROM
                variacao v
            JOIN 
                produto p ON p.id = v.produto_id
            JOIN
                categoria c ON c.id = p.categoria_id
            WHERE
                v.id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $d = $stmt->fetch();
        if (! $d )
            return null;


        $var = [
            'id' => $d['id'],
            'tamanho' => $d['tamanho'],
            'peso' => $d['peso'],
            'cor' => $d['cor'],
            'preco' => $d['preco'],
            'estoque' => $d['estoque'],
            
            'produto' => [
                'id' => $d['produto_id'],
                'nome' => $d['produto_nome'],
                'imagem_path' => $d['produto_imagem_path'],
                'descricao' => $d['produto_descricao'],
                'data_cadastro' => $d['produto_data_cadastro'],
                
                'categoria' => [
                    'id' => $d['produto_categoria_id'],
                    'nome' => $d['produto_categoria_nome'],
                    'descricao' => $d['produto_categoria_descricao']
                ]
            ]
        ];

        return $var;
    }
    
    public function salvar(array &$var) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<<'SQL'
                INSERT INTO variacao(
                    tamanho,
                    peso,
                    cor,
                    preco,
                    estoque,
                    produto_id
                )

                VALUES (
                    :tamanho,
                    :peso,
                    :cor,
                    :preco,
                    :estoque,
                    :produto_id
                );
            SQL;

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'tamanho'=> $var['tamanho'],
                'peso'=> $var['peso'],
                'cor'=> $var['cor'],
                'preco'=> $var['preco'],
                'estoque'=> $var['estoque'],
                'produto_id'=> $var['produto_id']
            ]);
            
            $var['id'] = $this->pdo->lastInsertId();
            
            $this->pdo->commit();

            if ($stmt->rowCount())
                return true;
            return false;
        } catch ( PDOException $e ) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function alterar( array $var ) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                UPDATE 
                    variacao 
                SET 
                    tamanho = :tamanho,
                    peso = :peso,
                    cor = :cor,
                    preco = :preco,
                    estoque = :estoque,
                    produto_id = :produto_id
                WHERE 
                    id = :id;
            SQL;
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'tamanho'=> $var['tamanho'],
                'peso'=> $var['peso'],
                'cor'=> $var['cor'],
                'preco'=> $var['preco'],
                'estoque'=> $var['estoque'],
                'produto_id'=> $var['produto_id'],
                'id' => $var['id']
            ]);
            
            $this->pdo->commit();
            
            if ($stmt->rowCount())
                return true;
            return false;
        } catch ( PDOException $e ) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function remover($id) {
        try {
            $this->pdo->beginTransaction();

            
            $sql = 'DELETE FROM variacao WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $id
            ]);
    
            $this->pdo->commit();
            
            if ($stmt->rowCount())
                return true;
            return false;
        } catch ( PDOException $e ) {
            $this->pdo->rollBack(); 
            throw $e;
        }
    }

}

?>