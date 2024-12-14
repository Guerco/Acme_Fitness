<?php

class ProdutoDao {

    public function __construct (
        private PDO $pdo
    ){}

    public function buscarTudo() {
        
        $sql = <<<'SQL'
            SELECT 
                p.id, 
                p.nome, 
                p.imagem_path, 
                p.descricao, 
                p.data_cadastro, 
                
                c.id AS categoria_id, 
                c.nome AS categoria_nome, 
                c.descricao AS categoria_descricao
            FROM 
                produto p 
            JOIN 
                categoria c ON c.id=p.categoria_id;
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $produtos = [];

        foreach($stmt as $d) {
            $produtos [] = [
                'id' => $d['id'],
                'nome' => $d['nome'],
                'imagem_path' => $d['imagem_path'],
                'descricao' => $d['descricao'],
                'data_cadastro' => $d['data_cadastro'],
                
                'categoria' => [
                    'id' => $d['categoria_id'],
                    'nome' => $d['categoria_nome'],
                    'descricao' => $d['categoria_descricao']
                ]
            ];

        }
        return $produtos;
    }

    public function buscarPeloId($id) {
        
        $sql = <<<'SQL'
            SELECT 
                p.id, 
                p.nome, 
                p.imagem_path, 
                p.descricao, 
                p.data_cadastro, 
                
                c.id AS categoria_id, 
                c.nome AS categoria_nome, 
                c.descricao AS categoria_descricao
            FROM 
                produto p 
            JOIN   
                categoria c ON c.id=p.categoria_id 
            WHERE p.id = :id;
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $d = $stmt->fetch();
        if ( ! $d )
            return null;


        $pdt = [
            'id' => $d['id'],
            'nome' => $d['nome'],
            'imagem_path' => $d['imagem_path'],
            'descricao' => $d['descricao'],
            'data_cadastro' => $d['data_cadastro'],
            
            'categoria' => [
                'id' => $d['categoria_id'],
                'nome' => $d['categoria_nome'],
                'descricao' => $d['categoria_descricao']
            ]
        ];

        return $pdt;
    }
    
    public function salvar(array &$pdt) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                INSERT INTO produto(
                    nome, 
                    imagem_path, 
                    descricao, 
                    data_cadastro, 
                    categoria_id
                )

                VALUES (
                    :nome, 
                    :imagem_path, 
                    :descricao, 
                    :data_cadastro, 
                    :categoria_id
                );
            SQL;   

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'nome'=> $pdt['nome'],
                'imagem_path'=> $pdt['imagem_path'],
                'descricao'=> $pdt['descricao'],
                'data_cadastro'=> $pdt['data_cadastro'],
                'categoria_id'=> $pdt['categoria_id'],
            ]);
            
            $pdt['id'] = $this->pdo->lastInsertId();
            
            $this->pdo->commit();

            if ($stmt->rowCount())
                return true;
            return false;
        } catch ( PDOException $e ) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function alterar( array $pdt ) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                UPDATE 
                    produto 
                SET 
                    nome = :nome, 
                    imagem_path = :imagem_path, 
                    descricao = :descricao, 
                    data_cadastro = :data_cadastro, 
                    categoria_id = :categoria_id
                WHERE 
                    id = :id;
            SQL;
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'nome'=> $pdt['nome'],
                'imagem_path'=> $pdt['imagem_path'],
                'descricao'=> $pdt['descricao'],
                'data_cadastro'=> $pdt['data_cadastro'],
                'categoria_id'=> $pdt['categoria_id'],
                'id' => $pdt['id']
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

            
            $sql = 'DELETE FROM produto WHERE id = :id';
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