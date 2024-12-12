<?php

class Endereco {

    public function __construct(
        private int $id,
        private string $logradouro,
        private string $cidade,
        private string $bairro,
        private string $numero,
        private string $cep,
        private string $complemento
    ) {}

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getLogradouro(): string {
        return $this->logradouro;
    }

    public function getCidade(): string {
        return $this->cidade;
    }

    public function getBairro(): string {
        return $this->bairro;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getCep(): string {
        return $this->cep;
    }

    public function getComplemento(): string {
        return $this->complemento;
    }
}
?>
