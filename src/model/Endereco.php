<?php

require_once __DIR__.'/DominioException.php';

class Endereco {

    /**
     * @param int $id
     * @param string $logradouro
     * @param string $cidade
     * @param string $bairro
     * @param string $numero
     * @param string $cep
     * @param string $complemento
     */
    public function __construct(
        private ?int $id,
        private ?string $logradouro,
        private ?string $cidade,
        private ?string $bairro,
        private ?string $numero,
        private ?string $cep,
        private ?string $complemento
    ) {}

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getLogradouro(): ?string {
        return $this->logradouro;
    }

    public function getCidade(): ?string {
        return $this->cidade;
    }

    public function getBairro(): ?string {
        return $this->bairro;
    }

    public function getNumero(): ?string {
        return $this->numero;
    }

    public function getCep(): ?string {
        return $this->cep;
    }

    public function getComplemento(): ?string {
        return $this->complemento;
    }

     // Validação
     public function validar() {
        $erros = [];

        // Verifica se o id, caso atribuido, seja um número não negativo
        if ( $this->id ) {
            if ( $this->id < 0 )
                $erros[] = 'O id deve ser inteiro e não negativo.';
        }

        // Verifica se o logradouro foi preenchido
        if ( empty( $this->logradouro ) ) {
            $erros[] = 'O logradouro é obrigatório.';
        } 
        
        // Verifica se o numero foi preenchido e se é numérico
        if ( empty( $this->numero ) ) {
            $erros[] = 'O numero é obrigatório.';
        } else if ( ! is_numeric($this->numero)) {
            $erros[] = 'O número deve possuir apenas valores numéricos';
        }
        
        // Verifica se o bairro foi preenchido
        if ( empty( $this->bairro ) ) {
            $erros[] = 'O bairro é obrigatório.';
        } 
        
        // Verifica se a cidade foi preenchida
        if ( empty( $this->cidade ) ) {
            $erros[] = 'A cidade é obrigatória.';
        } 

        // Verifica se o cep foi preenchido e se segue o formato definido
        if ( empty( $this->cep ) ) {
            $erros[] = 'O cep é obrigatório.';
        } else if ( ! $this->validarCep($this->cep) ) {
            $erros[] = 'O cep deve estar no formato XXXXX-XXX';
        }

        if ( $erros ) {
            $erros_json = json_encode( $erros, JSON_UNESCAPED_UNICODE );
            throw new DominioException($erros_json);
        }
    }

    private function validarCep ( $cep ) {
        $formato = '/^\d{5}\-\d{3}$/';

        return preg_match($formato, $cep);
    }

}
?>
