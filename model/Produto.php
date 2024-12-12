<?php

require_once __DIR__.'/Categoria.php';

class Produto {

    public function __construct(
        private int $id,
        private string $nome,
        private string $imagem_path,
        private string $descricao,
        private DateTime $data_cadastro,
        private Categoria $categoria
    ) {}

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getImagemPath(): string {
        return $this->imagem_path;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function getDataCadastro(): DateTime {
        return $this->data_cadastro;
    }

    public function getCategoria(): Categoria {
        return $this->categoria;
    }

}

?>
