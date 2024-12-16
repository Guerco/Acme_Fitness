<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../src/model/Categoria.php';

class CategoriaTest extends TestCase {

    protected $categoria;

    public function setUp(): void {
        $this->categoria= new Categoria(
            id: 1,
            nome: 'Categoria',
            descricao: 'Descrição da Categoria'
        );
    }

    public function testValidacao() {
        $this->categoria->validar();

        $this->assertTrue(true); // Verifica se alcançou esta linha sem disparar exceções
    }

}

?>