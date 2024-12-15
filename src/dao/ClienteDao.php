<?php

class ClienteDao {

    public function __construct (
        private PDO $pdo
    ){}

    public function buscarTudo() {
        $sql = <<< 'SQL'
            SELECT 
                id, 
                nome, 
                cpf,
                data_nascimento 
            FROM 
                cliente;
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPeloId($id) {
        $sql = <<< 'SQL'
            SELECT 
                id, 
                nome, 
                cpf,
                data_nascimento 
            FROM 
                cliente
            WHERE 
                id = :id;
        SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
    
    public function salvar(array &$cli) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                INSERT INTO cliente(
                    nome, 
                    cpf,
                    data_nascimento
                ) 
                
                VALUES (
                    :nome, 
                    :cpf,
                    :data_nascimento
                );
            SQL;
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'nome'=> $cli['nome'],
                'cpf'=> $cli['cpf'],
                'data_nascimento'=> $cli['data_nascimento']
            ]);
            
            $cli['id'] = $this->pdo->lastInsertId();
            
            $this->pdo->commit();

            if ($stmt->rowCount())
                return true;
            return false;
        } catch ( PDOException $e ) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function alterar( array $cli ) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                UPDATE 
                    cliente
                SET
                    nome = :nome,
                    cpf = :cpf,
                    data_nascimento = :data_nascimento
                WHERE
                    id = :id;
            SQL; 
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'nome'=> $cli['nome'],
                'cpf'=> $cli['cpf'],
                'data_nascimento'=> $cli['data_nascimento'],
                'id' => $cli['id']
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

            
            $sql = 'DELETE FROM cliente WHERE id = :id';
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