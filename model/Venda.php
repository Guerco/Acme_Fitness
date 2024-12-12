<?php

require_once __DIR__.'/Cliente.php';
require_once __DIR__.'/Endereco.php';
require_once __DIR__.'/Variacao.php';

class Venda{

    private $variacoes_venda = [];
    private float $valor_frete = 10.0;
    private float $valor_total = 0.0;

    public function __construct(
        private int $id,
        private float $descontos,
        private string $forma_pagamento,
        private Cliente $cliente,
        private Endereco $endereco
    ){}

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getValorTotal(): float {
        return $this->valor_total;
    }

    public function getValorFrete(): float {
        return $this->valor_frete;
    }

    public function getDescontos(): float {
        return $this->descontos;
    }

    public function getFormaPagamento(): string {
        return $this->forma_pagamento;
    }

    public function getCliente(): Cliente {
        return $this->cliente;
    }

    public function getEndereco(): Endereco {
        return $this->endereco;
    }

    public function getVariacoesVenda(): array {
        return $this->variacoes_venda;
    }


    // Setters

    /**
     * Adiciona na lista uma variação de um produto na venda e sua respectiva quantidade.
     * @param Variacao $variacao
     * @param int $quantidade
     * @return void
     */
    public function addVariacoesVenda(Variacao $variacao, int $quantidade): void {
        $this->variacoes_venda[] = ['variacao' => $variacao, 'quantidade' => $quantidade];
    }

    /**
     * Calcula e preenche o valor total da Venda após o preenchimento das Variações selecionadas.
     * @return void
     */
    public function calcularValorTotal() {
        $soma = 0;

        foreach ( $this->variacoes_venda as $v ) {
            $soma += $v['variacao']->getPreco() * $v['quantidade'] ;
        }

        $this->valor_total =  $soma + $this->valor_frete - $this->descontos;
    }
}

?>