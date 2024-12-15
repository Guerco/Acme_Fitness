<?php

require_once __DIR__.'/DominioException.php';

class Categoria {
    
    /**
     * @param int $id
     * @param string $nome
     * @param string $descricao
     */
    public function __construct(
        private ?int $id, 
        private ?string $nome, 
        private ?string $descricao
    ) {}

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getNome(): ?string {
        return $this->nome;
    }

    public function getDescricao(): ?string {
        return $this->descricao;
    }


    // Validação
    public function validar() {
        $erros = [];

        // Verifica se o id, caso atribuido, seja um número não negativo
        if ( $this->id ) {
            if ( $this->id < 0 )
                $erros[] = 'O id deve ser inteiro e não negativo.';
        }

        // Verifica se o nome foi preenchido
        if ( empty( $this->nome ) ) {
            $erros[] = 'O nome é obrigatório.';
        } 

        if ( $erros ) {
            $erros_json = json_encode( $erros, JSON_UNESCAPED_UNICODE );
            throw new DominioException($erros_json);
        }
    }

}

?>
