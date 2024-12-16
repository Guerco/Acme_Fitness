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

     // Validação
     public function validar() {
        $erros = [];

        // Verifica se o id, caso atribuido, seja um número não negativo
        if ( $this->id ) {
            if ( $this->id < 0 )
                $erros[] = 'O id deve ser inteiro e não negativo.';
        }

        // Verifica se o logradouro foi preenchido e possui no máximo 50 caracteres
        if ( empty( $this->logradouro ) ) {
            $erros[] = 'O logradouro é obrigatório.';
        } else if ( mb_strlen( $this->logradouro ) > 50) {
            $erros[] = 'O logradouro deve possuir no máximo 50 caracteres.';
        }

        
        // Verifica se o numero foi preenchido, se é numérico e se possui no máximo 10 caracteres
        if ( empty( $this->numero ) ) {
            $erros[] = 'O numero é obrigatório.';
        } else {
            if ( ! is_numeric($this->numero)) {
                $erros[] = 'O número deve possuir apenas valores numéricos';
            } else if ( mb_strlen( $this->numero ) > 10) {
                $erros[] = 'O número deve possuir no máximo 10 caracteres.';
            }
        }

        
        // Verifica se o bairro foi preenchido e se possui no máximo 50 caracteres
        if ( empty( $this->bairro ) ) {
            $erros[] = 'O bairro é obrigatório.';
        } else if ( mb_strlen( $this->bairro ) > 50) {
            $erros[] = 'O bairro deve possuir no máximo 50 caracteres.';
        }
        
        
        // Verifica se a cidade foi preenchida e se possui no máximo 10 caracteres
        if ( empty( $this->cidade ) ) {
            $erros[] = 'A cidade é obrigatória.';
        } else if ( mb_strlen( $this->cidade ) > 50) {
            $erros[] = 'A cidade deve possuir no máximo 50 caracteres.';
        } 

        // Verifica se o cep foi preenchido e se segue o formato definido
        if ( empty( $this->cep ) ) {
            $erros[] = 'O cep é obrigatório.';
        } else if ( ! $this->validarCep($this->cep) ) {
            $erros[] = 'O cep deve estar no formato XXXXX-XXX';
        }

        // Verifica se o complemento, caso preenchido, possui no máximo 50 caracteres
        if (!  empty( $this->complemento ) ) {
            if ( mb_strlen( $this->complemento ) > 50) {
                $erros[] = 'O complemento deve possuir no máximo 50 caracteres.';
            }
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
