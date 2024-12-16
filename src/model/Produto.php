<?php

require_once __DIR__.'/DominioException.php';
require_once __DIR__.'/Categoria.php';

class Produto {

    /**
     * @param int $id
     * @param string $nome
     * @param string $imagem_path
     * @param string $descricao
     * @param string $data_cadastro
     * @param Categoria $categoria
     */
    public function __construct(
        private ?int $id,
        private ?string $nome,
        private ?string $imagem_path,
        private ?string $descricao,
        private ?string $data_cadastro,
        private ?Categoria $categoria
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

        // Verifica se o nome foi preenchido e se possui no máximo 50 caracteres
        if ( empty( $this->nome ) ) {
            $erros[] = 'O nome é obrigatório.';
        } else if ( mb_strlen( $this->nome ) > 50) {
            $erros[] = 'O nome deve possuir no máximo 50 caracteres.';
        }

        // Verifica se o caminho da imagem, caso preenchido, possui no máximo 200 caracteres
        if (!  empty( $this->imagem_path ) ) {
            if ( mb_strlen( $this->imagem_path ) > 200) {
                $erros[] = 'O caminho da imagem deve possuir no máximo 200 caracteres.';
            }
        } 

        
        // Verifica se a categoria foi preenchida e se possui um id inteiro e não negativo
        if ( empty( $this->categoria ) ) 
        {
            $erros[] = 'A categoria é obrigatória.';
        }
        else if ( empty( $this->categoria->getId() ) )
        {
            $erros[] = 'O id da categoria é obrigatório.';
        } 
        else if ( ! is_int($this->categoria->getId()) 
        ||  $this->categoria->getId() < 0 ) 
        {
            $erros[] = 'O id da categoria deve ser um inteiro não negativo.';
        }

        // Verifica se a data de cadastro foi preenchida, se segue o formato definido e se é válida
        if ( empty( $this->data_cadastro ) ) {
            $erros[] = 'A data de cadastro é obrigatória.';
        } else if ( ! $this->validarData($this->data_cadastro) ) {
            $erros[] = 'O campo data_cadastro deve ser uma data válida no formato AAAA-MM-DD';
        }

        if ( $erros ) {
            $erros_json = json_encode( $erros, JSON_UNESCAPED_UNICODE );
            throw new DominioException($erros_json);
        }
    }

    private function validarData ( $data ) {
        $formato = '/^\d{4}\-\d{2}\-\d{2}$/';

        if ( ! preg_match($formato, $data) )
            return false;

        $ano = explode('-', $data)[0];
        $mes = explode('-', $data)[1];
        $dia = explode('-', $data)[2];

        return checkdate($mes, $dia, $ano);
    }

}

?>
