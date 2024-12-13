<?php

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

}

?>
