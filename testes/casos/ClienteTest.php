<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../src/model/Cliente.php';

class ClienteTest extends TestCase {

    protected $cliente;

    public function setUp(): void {
        $this->cliente= new Cliente(
            id: 1,
            nome: 'Cliente',
            cpf: '123.456.789-00',
            data_nascimento: '2000-01-01'
        );
    }

    public function testValidacao() {
        $this->cliente->validar();

        $this->assertTrue(true); // Verifica se alcançou esta linha sem disparar exceções
    }

}

?>