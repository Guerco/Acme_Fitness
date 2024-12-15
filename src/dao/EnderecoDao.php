<?php

class EnderecoDao {

    public function __construct (
        private PDO $pdo
    ){}

    public function buscarTudo() {
        $sql = <<< 'SQL'
            SELECT 
                id, 
                logradouro,
                cidade,
                bairro,
                numero,
                cep,
                complemento
            FROM 
                endereco;
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPeloId($id) {
        $sql = <<< 'SQL'
            SELECT 
                id, 
                logradouro,
                cidade,
                bairro,
                numero,
                cep,
                complemento
            FROM 
                endereco
            WHERE 
                id = :id;
        SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
    
    public function salvar(array &$end) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                INSERT INTO endereco(
                    logradouro,
                    cidade,
                    bairro,
                    numero,
                    cep,
                    complemento
                ) 
                
                VALUES (
                    :logradouro,
                    :cidade,
                    :bairro,
                    :numero,
                    :cep,
                    :complemento
                );
            SQL;
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'logradouro'=> $end['logradouro'],
                'cidade'=> $end['cidade'],
                'bairro'=> $end['bairro'],
                'numero'=> $end['numero'],
                'cep'=> $end['cep'],
                'complemento'=> $end['complemento']
            ]);
            
            $end['id'] = $this->pdo->lastInsertId();
            
            $this->pdo->commit();

            if ($stmt->rowCount())
                return true;
            return false;
        } catch ( PDOException $e ) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function alterar( array $end ) {
        try {
            $this->pdo->beginTransaction();

            $sql = <<< 'SQL'
                UPDATE 
                    endereco
                SET
                    logradouro = :logradouro,
                    cidade = :cidade,
                    bairro = :bairro,
                    numero = :numero,
                    cep = :cep,
                    complemento = :complemento
                WHERE
                    id = :id;
            SQL; 
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'logradouro'=> $end['logradouro'],
                'cidade'=> $end['cidade'],
                'bairro'=> $end['bairro'],
                'numero'=> $end['numero'],
                'cep'=> $end['cep'],
                'complemento'=> $end['complemento'],
                'id' => $end['id']
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
            
            $sql = 'DELETE FROM endereco WHERE id = :id';
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