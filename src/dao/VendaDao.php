<?php

require_once __DIR__.'/../model/DominioException.php';

class VendaDao {

    public function __construct (
        private PDO $pdo
    ){}

    public function buscarTudo() {
        $sql = <<< 'SQL'
            SELECT 
                ve.id,
                ve.valor_total,
                ve.valor_frete,
                ve.descontos,
                ve.forma_pagamento,
                
                cl.id               AS cliente_id,
                cl.nome             AS cliente_nome,
                cl.cpf              AS cliente_cpf,
                cl.data_nascimento  AS cliente_data_nascimento,

                en.id           AS endereco_id,
                en.logradouro   AS endereco_logradouro,
                en.cidade       AS endereco_cidade,
                en.bairro       AS endereco_bairro,
                en.numero       AS endereco_numero,
                en.cep          AS endereco_cep,
                en.complemento  AS endereco_complemento,

                vv.id           AS variacao_venda_id,
                vv.quantidade   AS variacao_venda_quantidade,

                va.id       AS variacao_id,
                va.tamanho  AS variacao_tamanho,
                va.peso     AS variacao_peso,
                va.cor      AS variacao_cor,
                va.preco    AS variacao_preco,
                va.estoque  AS variacao_estoque,

                pr.id               AS produto_id,
                pr.nome             AS produto_nome,
                pr.imagem_path      AS produto_imagem_path,
                pr.descricao        AS produto_descricao,
                pr.data_cadastro    AS produto_data_cadastro,

                ca.id           AS categoria_id,
                ca.nome         AS categoria_nome,
                ca.descricao    AS categoria_descricao
            FROM
                venda ve
            JOIN
                cliente cl ON cl.id = ve.cliente_id
            JOIN
                endereco en ON en.id = ve.endereco_id
            JOIN
                variacao_venda vv ON ve.id = vv.venda_id
            JOIN 
                variacao va ON va.id = vv.variacao_id
            JOIN 
                produto pr ON pr.id = va.produto_id
            JOIN
                categoria ca ON ca.id = pr.categoria_id;
        SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $vendas = [];
        $venda = [];

        foreach($stmt as $d) {            
            if ( !isset($vendas[$d['id']]) ) {
                $venda['id'] = $d['id'];
                $venda['valor_total'] = $d['valor_total'];
                $venda['valor_frete'] = $d['valor_frete'];
                $venda['descontos'] = $d['descontos'];
                $venda['forma_pagamento'] = $d['forma_pagamento'];

                $venda['cliente']['id'] = $d['cliente_id'];
                $venda['cliente']['nome'] = $d['cliente_nome'];
                $venda['cliente']['cpf'] = $d['cliente_cpf'];
                $venda['cliente']['data_nascimento'] = $d['cliente_data_nascimento'];
                
                $venda['endereco']['id'] = $d['endereco_id'];
                $venda['endereco']['logradouro'] = $d['endereco_logradouro'];
                $venda['endereco']['cidade'] = $d['endereco_cidade'];
                $venda['endereco']['bairro'] = $d['endereco_bairro'];
                $venda['endereco']['numero'] = $d['endereco_numero'];
                $venda['endereco']['cep'] = $d['endereco_cep'];
                $venda['endereco']['complemento'] = $d['endereco_complemento'];

                $venda['itens'] = [];
            }

            $item = [
                'id' => $d['variacao_venda_id'],
                'quantidade' => $d['variacao_venda_quantidade'],
                
                'variacao' => [
                    'id' => $d['variacao_id'],
                    'tamanho' => $d['variacao_tamanho'],
                    'peso' => $d['variacao_peso'],
                    'cor' => $d['variacao_cor'],
                    'preco' => $d['variacao_preco'],
                    'estoque' => $d['variacao_estoque'],

                    'produto' => [
                        'id' => $d['produto_id'],
                        'nome' => $d['produto_nome'],
                        'imagem_path' => $d['produto_imagem_path'],
                        'descricao' => $d['produto_descricao'],
                        'data_cadastro' => $d['produto_data_cadastro'],

                        'categoria' => [
                            'id' => $d['categoria_id'],
                            'nome' => $d['categoria_nome'],
                            'decricao' => $d['categoria_descricao'],
                        ]
                    ]
                ] 
            ];

            $venda['itens'][] = $item; 

            $vendas[$d['id']] = $venda;
        }
        return $vendas;
    }

    public function buscarPeloId($id) {
        
        $sql = <<< 'SQL'
            SELECT 
                ve.id,
                ve.valor_total,
                ve.valor_frete,
                ve.descontos,
                ve.forma_pagamento,
                
                cl.id               AS cliente_id,
                cl.nome             AS cliente_nome,
                cl.cpf              AS cliente_cpf,
                cl.data_nascimento  AS cliente_data_nascimento,

                en.id           AS endereco_id,
                en.logradouro   AS endereco_logradouro,
                en.cidade       AS endereco_cidade,
                en.bairro       AS endereco_bairro,
                en.numero       AS endereco_numero,
                en.cep          AS endereco_cep,
                en.complemento  AS endereco_complemento,

                vv.id           AS variacao_venda_id,
                vv.quantidade   AS variacao_venda_quantidade,

                va.id       AS variacao_id,
                va.tamanho  AS variacao_tamanho,
                va.peso     AS variacao_peso,
                va.cor      AS variacao_cor,
                va.preco    AS variacao_preco,
                va.estoque  AS variacao_estoque,

                pr.id               AS produto_id,
                pr.nome             AS produto_nome,
                pr.imagem_path      AS produto_imagem_path,
                pr.descricao        AS produto_descricao,
                pr.data_cadastro    AS produto_data_cadastro,

                ca.id           AS categoria_id,
                ca.nome         AS categoria_nome,
                ca.descricao    AS categoria_descricao
            FROM
                venda ve
            JOIN
                cliente cl ON cl.id = ve.cliente_id
            JOIN
                endereco en ON en.id = ve.endereco_id
            JOIN
                variacao_venda vv ON ve.id = vv.venda_id
            JOIN 
                variacao va ON va.id = vv.variacao_id
            JOIN 
                produto pr ON pr.id = va.produto_id
            JOIN
                categoria ca ON ca.id = pr.categoria_id
            WHERE
                ve.id = :id;
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $venda = [];

        foreach($stmt as $d) {            
            if ( ! array_key_exists('id', $venda) ) {
                $venda['id'] = $d['id'];
                $venda['valor_total'] = $d['valor_total'];
                $venda['valor_frete'] = $d['valor_frete'];
                $venda['descontos'] = $d['descontos'];
                $venda['forma_pagamento'] = $d['forma_pagamento'];

                $venda['cliente']['id'] = $d['cliente_id'];
                $venda['cliente']['nome'] = $d['cliente_nome'];
                $venda['cliente']['cpf'] = $d['cliente_cpf'];
                $venda['cliente']['data_nascimento'] = $d['cliente_data_nascimento'];
                
                $venda['endereco']['id'] = $d['endereco_id'];
                $venda['endereco']['logradouro'] = $d['endereco_logradouro'];
                $venda['endereco']['cidade'] = $d['endereco_cidade'];
                $venda['endereco']['bairro'] = $d['endereco_bairro'];
                $venda['endereco']['numero'] = $d['endereco_numero'];
                $venda['endereco']['cep'] = $d['endereco_cep'];
                $venda['endereco']['complemento'] = $d['endereco_complemento'];

                $venda['itens'] = [];
            }

            $item = [
                'id' => $d['variacao_venda_id'],
                'quantidade' => $d['variacao_venda_quantidade'],
                
                'variacao' => [
                    'id' => $d['variacao_id'],
                    'tamanho' => $d['variacao_tamanho'],
                    'peso' => $d['variacao_peso'],
                    'cor' => $d['variacao_cor'],
                    'preco' => $d['variacao_preco'],
                    'estoque' => $d['variacao_estoque'],

                    'produto' => [
                        'id' => $d['produto_id'],
                        'nome' => $d['produto_nome'],
                        'imagem_path' => $d['produto_imagem_path'],
                        'descricao' => $d['produto_descricao'],
                        'data_cadastro' => $d['produto_data_cadastro'],

                        'categoria' => [
                            'id' => $d['categoria_id'],
                            'nome' => $d['categoria_nome'],
                            'decricao' => $d['categoria_descricao'],
                        ]
                    ]
                ] 
            ];

            $venda['itens'][] = $item; 
        }

        return $venda;
    }
    
    public function salvar(array &$ven) {
        try {
            $this->pdo->beginTransaction();

            $insert_venda = <<<'SQL'
                INSERT INTO venda(
                    valor_total,
                    valor_frete,
                    descontos,
                    forma_pagamento,
                    cliente_id,
                    endereco_id
                )

                VALUES (
                    :valor_total,
                    :valor_frete,
                    :descontos,
                    :forma_pagamento,
                    :cliente_id,
                    :endereco_id
                );
            SQL;

            $stmt = $this->pdo->prepare($insert_venda);
            $stmt->execute([
                'valor_total'=> $ven['valor_total'],
                'valor_frete'=> $ven['valor_frete'],
                'descontos'=> $ven['descontos'] ?? 0.0,
                'forma_pagamento'=> $ven['forma_pagamento'],
                'cliente_id'=> $ven['cliente']['id'],
                'endereco_id'=> $ven['endereco']['id']
            ]);
            
            $ven['id'] = $this->pdo->lastInsertId();

            $insert_variacao_venda = <<<'SQL'
                INSERT INTO variacao_venda(
                    quantidade,
                    variacao_id,
                    venda_id
                )

                VALUES (
                    :quantidade,
                    :variacao_id,
                    :venda_id
                );
            SQL;
            
            $update_estoque = <<<'SQL'
                UPDATE 
                    variacao 
                SET 
                    estoque = estoque - :quantidade
                WHERE id = :variacao_id;
            SQL;

            foreach ( $ven['itens'] as $it ) {
                $stmt = $this->pdo->prepare($update_estoque);
                $stmt->execute([
                    'quantidade'=> $it['quantidade'],
                    'variacao_id'=> $it['variacao']['id'],
                ]);
                
                $stmt = $this->pdo->prepare($insert_variacao_venda);
                $stmt->execute([
                    'quantidade'=> $it['quantidade'],
                    'variacao_id'=> $it['variacao']['id'],
                    'venda_id'=> $ven['id']
                ]);
            }
            
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

            
            $sql = 'DELETE FROM venda  WHERE id = :id';
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