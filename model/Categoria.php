<?php

class Categoria {
    
    public function __construct(
        private int $id, 
        private string $nome, 
        private string $descricao
    ) {}

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

}

?>
