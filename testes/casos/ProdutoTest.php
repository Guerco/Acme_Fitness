<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../src/model/Produto.php';
require_once __DIR__ . '/../../src/model/Categoria.php';

class ProdutoTest extends TestCase {

    protected $produto;

    public function setUp(): void {
        $this->produto = new Produto(
            id: 1,
            nome: 'Produto',
            imagem_path: '/caminho/da/imagem',
            descricao: 'Descrição do Produto',
            data_cadastro: '2024-12-16',
            categoria: new Categoria(1,null,null)
        );
    }

    public function testValidacao() {
        $this->produto->validar();

        $this->assertTrue(true); // Verifica se alcançou esta linha sem disparar exceções
    }
    

}

?>