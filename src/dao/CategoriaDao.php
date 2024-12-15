<?php

class CategoriaDao {

    public function __construct (
        private PDO $pdo
    ){}

    public function buscarTudo() {
        $sql = <<< 'SQL'
            SELECT 
                id, 
                nome, 
                descricao 
            FROM 
                categoria;
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPeloId($id) {
        $sql = 'SELECT id, nome, descricao FROM categoria WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
    
    public function salvar(array &$cat) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                INSERT INTO categoria(
                    nome, 
                    descricao
                ) 
                
                VALUES (
                    :nome, 
                    :descricao
                );
            SQL;
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'nome'=> $cat['nome'],
                'descricao'=> $cat['descricao']
            ]);
            
            $cat['id'] = $this->pdo->lastInsertId();
            
            $this->pdo->commit();
            
            if ($stmt->rowCount())
                return true;
            return false;
        } catch ( PDOException $e ) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function alterar( array $cat ) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                UPDATE 
                    categoria
                SET
                    nome = :nome,
                    descricao = :descricao
                WHERE
                    id = :id;
            SQL; 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'nome' => $cat['nome'],
                'descricao' => $cat['descricao'],
                'id' => $cat['id']
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

            
            $sql = 'DELETE FROM categoria WHERE id = :id';
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