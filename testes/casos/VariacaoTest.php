<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../src/model/Variacao.php';
require_once __DIR__ . '/../../src/model/Produto.php';

class VariacaoTest extends TestCase {

    protected $variacao;

    public function setUp(): void {
        $this->variacao = new Variacao(
            id: 1,
            tamanho: 'Grande',
            peso: '10kg',
            cor: 'Azul',
            preco: 50.00,
            estoque: 10,
            produto: new Produto(1,null,null, null, null, null)
        );
    }

    public function testValidacao() {
        $this->variacao->validar();

        $this->assertTrue(true); // Verifica se alcançou esta linha sem disparar exceções
    }
    

}

?>