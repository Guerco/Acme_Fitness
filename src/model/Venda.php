<?php

require_once __DIR__.'/DominioException.php';
require_once __DIR__.'/Cliente.php';
require_once __DIR__.'/Endereco.php';
require_once __DIR__.'/Variacao.php';

class Venda{

    const VALOR_FRETE = 10.0;
    private float $valor_total = 0.0;
    private $itens = [];
    /**
     * @param int $id
     * @param string $forma_pagamento
     * @param Cliente $cliente
     * @param Endereco $endereco
     */
    public function __construct(
        private ?int $id,
        private ?float $descontos,
        private ?string $forma_pagamento,
        private ?Cliente $cliente,
        private ?Endereco $endereco
    ){}

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getValorTotal(): ?float {
        return $this->valor_total;
    }

    public function getDescontos(): ?float {
        return $this->descontos;
    }

    public function getFormaPagamento(): ?string {
        return $this->forma_pagamento;
    }

    public function getCliente(): ?Cliente {
        return $this->cliente;
    }

    public function getEndereco(): ?Endereco {
        return $this->endereco;
    }

    public function getItens(): ?array {
        return $this->itens;
    }


    // Setters
    public function addItens(?Variacao $variacao, ?int $quantidade): void {
        if (! $variacao ) {
            throw new DominioException('A variação é obrigatória.');
        } 

        if (! $quantidade ) {
            throw new DominioException('A quantidade da variação é obrigatória.');
        } else if ( $quantidade <= 0 ) {
            throw new DominioException('A quantidade da variação deve ser um numero inteiro positivo e diferente de 0.');
        }
        
        $ja_registrado = false;
        
        if ($variacao->getEstoque() < $quantidade) {
            throw new DominioException('A variação não possui estoque o suficiente.');
        } 

        foreach($this->itens as &$it) {
            if ( $it['variacao']->getId() == $variacao->getId() ) {
                $it['quantidade'] += $quantidade;
                $ja_registrado = true;
                break;
            }
        } 
        
        if ( ! $ja_registrado ) {
            $this->itens[] = ['variacao' => $variacao, 'quantidade' => $quantidade];
        }

        $this->valor_total = $this->calcularValorTotal();
    }

    public function calcularValorTotal() {
        $soma = 0;

        foreach ( $this->itens as $v ) {
            $soma += $v['variacao']->getPreco() * $v['quantidade'] ;
        }

        $descontos = $this->descontos ?? 0.0;
        return $soma + self::VALOR_FRETE - $descontos;
    }


    // Validação 
    public function validar() {
        $erros = [];

        // Verifica se o id, caso atribuido, seja um número não negativo
        if ( $this->id  ) {
            if ( $this->id < 0 )
                $erros[] = 'O id deve ser um inteiro não negativo.';
        }

        // Verifica se os descontos, caso atribuidos, sejam um número não negativo
        if ( $this->descontos ) {
            if ( $this->descontos < 0 ) {
                $erros[] = 'O valor dos descontos deve ser um número não negativo';
            }
        } 
        
        // Verifica se a forma de pagamento foi preenchida e se seu valor é válido
        if ( empty( $this->forma_pagamento ) ) {
            $erros[] = 'A forma de pagamento é obrigatória.';
        } else if ( ! $this->validarFormaPagamento( $this->forma_pagamento ) ) {
            $erros[] = 'O forma de pagamento deve ser: PIX, Boleto ou Cartão (1x)';
        }
        
        // Verifica se o cliente foi preenchido e se possui um id inteiro e não negativo
        if ( empty( $this->cliente )  ) {
            $erros[] = 'O cliente é obrigatório.';
        } else if ( empty( $this->cliente->getId() ) ) {
            $erros[] = 'O id do cliente é obrigatório';
        }
        else if ( ! is_int($this->cliente->getId()) 
            ||  $this->cliente->getId() < 0 ) 
        {
            $erros[] = 'O id do cliente deve ser um inteiro não negativo.';
        }

        // Verifica se o endereco foi preenchido e se possui um id inteiro e não negativo
        if ( empty( $this->endereco )  ) {
            $erros[] = 'O endereço é obrigatório.';
        } else if ( empty( $this->endereco->getId() ) ) {
            $erros[] = 'O id do endereço é obrigatório';
        }
        else if ( ! is_int($this->endereco->getId()) 
            ||  $this->endereco->getId() < 0 ) 
        {
            $erros[] = 'O id do endereco deve ser um inteiro não negativo.';
        }

        // Verifica se a lista de itens está vazia
        if ( empty($this->itens) ) {
            $erros[] = 'A venda deve possuir ao menos um item.';
        }
        
        if ( $erros ) {
            $erros_json = json_encode( $erros, JSON_UNESCAPED_UNICODE );
            throw new DominioException($erros_json);
        }
    }

    private function validarFormaPagamento(string $forma_pagamento) {
        $formas_permitidas = [
            'PIX',
            'Boleto',
            'Cartão (1x)'
        ];

        return in_array($forma_pagamento, $formas_permitidas);
    }

}

?>
