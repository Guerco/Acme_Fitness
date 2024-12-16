<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../src/model/Venda.php';
require_once __DIR__ . '/../../src/model/Cliente.php';
require_once __DIR__ . '/../../src/model/Endereco.php';
require_once __DIR__ . '/../../src/model/Variacao.php';

class VendaTest extends TestCase {

    protected $venda;

    public function setUp(): void {
        $this->venda = new Venda(
            id: 1,
            descontos: 20.00,
            forma_pagamento: 'PIX',
            cliente: new Cliente(1,null,null,null),
            endereco: new Endereco(1,null,null,null,null,null,null)
        );

        $this->venda->addItens(
            variacao: new Variacao(
                1,
                null,
                null,
                null,
                50.0,
                5,
                null
            ),
            quantidade: 1
        );
    }

    public function testValidacao() {
        $this->venda->validar();

        $this->assertTrue(true); // Verifica se alcançou esta linha sem disparar exceções
    }
    
    public function  testCalcularValorTotal() {
        $valor_total = $this->venda->calcularValorTotal();
        $valor_esperado = 40.0; // 50.0 (valor total dos itens) + 10.0 (valor do frete padrão) - 20.0 (descontos) 

        $this->assertEquals($valor_esperado, $valor_total);
    }

}

?>