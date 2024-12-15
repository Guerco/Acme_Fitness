<?php

require_once __DIR__.'/DominioException.php';
require_once __DIR__.'/Produto.php';

class Variacao {

    /**
     * @param int $id
     * @param string $tamanho
     * @param string $peso
     * @param string $cor
     * @param float $preco
     * @param int $estoque
     * @param Produto $produto
     */
    public function __construct(
        private ?int $id,
        private ?string $tamanho,
        private ?string $peso,
        private ?string $cor,
        private ?float $preco,
        private ?int $estoque,
        private ?Produto $produto
    ) {}

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getTamanho(): ?string {
        return $this->tamanho;
    }

    public function getPeso(): ?string {
        return $this->peso;
    }

    public function getCor(): ?string {
        return $this->cor;
    }

    public function getPreco(): ?float {
        return $this->preco;
    }

    public function getEstoque(): ?int {
        return $this->estoque;
    }

    public function getProduto(): ?Produto {
        return $this->produto;
    }

    // Validação
    public function validar() {
        $erros = [];

        // Verifica se o id, caso atribuido, seja um número não negativo
        if ( $this->id ) {
            if ( $this->id < 0 )
                $erros[] = 'O id deve ser um inteiro não negativo.';
        }

        // Verifica se o preco foi preenchido e se seu valor é válido
        if ( empty( $this->preco ) ) {
            $erros[] = 'O preço é obrigatório.';
        } else if ( $this-> preco <= 0 ) {
            $erros[] = 'O preço deve ser um número não negativo e diferente de zero';
        }
        
        // Verifica se o estoque foi preenchido e se seu valor é válido
        if ( empty( $this->estoque ) ) {
            $erros[] = 'O estoque é obrigatório.';
        } else if ( $this-> estoque <= 0 ) {
            $erros[] = 'O estoque deve ser um inteiro não negativo';
        }
        
        // Verifica se o produto foi preenchido e se possui id
        if ( empty( $this->produto )  ) {
            $erros[] = 'O produto é obrigatório.';
        } else if ( empty( $this->produto->getId() ) ) {
            $erros[] = 'O id do produto é obrigatório';
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
