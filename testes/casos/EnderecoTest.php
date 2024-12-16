<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../src/model/Endereco.php';

class EnderecoTest extends TestCase {

    protected $endereco;

    public function setUp(): void {
        $this->endereco= new Endereco(
            id: 1,
            logradouro: 'Logradouro do Endereço',
            cidade: 'Cidade do Endereço',
            bairro: 'Bairro do Endereço',
            numero: '123',
            cep: '12345-000',
            complemento: 'complemento do Endereço',
        );
    }

    public function testValidacao() {
        $this->endereco->validar();

        $this->assertTrue(true); // Verifica se alcançou esta linha sem disparar exceções
    }

}

?>