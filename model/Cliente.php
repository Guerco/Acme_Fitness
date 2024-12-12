<?php

class Cliente {

    public function __construct(
        private int $id,
        private string $nome,
        private string $cpf,
        private DateTime $data_nascimento
    ) {}

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function getDataNascimento(): DateTime {
        return $this->data_nascimento;
    }

}

?>
