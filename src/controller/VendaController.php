<?php

require_once __DIR__ . '/../dao/VendaDao.php';
require_once __DIR__ . '/../model/Venda.php';
require_once __DIR__ . '/../model/Cliente.php';
require_once __DIR__ . '/../model/Endereco.php';
require_once __DIR__ . '/../model/Variacao.php';
require_once __DIR__ . '/../model/DominioException.php';

class VendaController
{

    /**
     * @param VendaDao $dao
     * @param bool $exibir_detalhes Define se detalhes adicionais sobre as exceções são exibidos
     */
    public function __construct(
        private VendaDao $dao,
        private VariacaoDao $variacaoDao,
        private $exibir_detalhes = false
    ) {}

    public function listar() {
        try {
            $vendas = $this->dao->buscarTudo();

            // Em caso de sucesso na operação
            if ($vendas) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $vendas
                );

            // Em caso da operação não possuir retorno
            } else {
                $msg = 'Nenhum resultado encontrado.';

                $this->enviarResposta(
                    codigo: 404,
                    mensagem: $msg
                );
            }

        // Em caso de erro interno na realização da operação
        } catch (PDOException $e) {
            $msg = 'Não foi possível realizar a operação.';
            
            $this->enviarResposta(
                codigo: 500,
                mensagem: $msg,
                dados: null,
                erros: $e->getMessage()
            );
        }
    }
    public function buscar($id) {
        $this->verificarId($id);

        try {
            $venda = $this->dao->buscarPeloId($id);

            // Em caso de sucesso na operação
            if ($venda) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $venda
                );

            // Em caso da operação não possuir retorno
            } else {
                $msg = 'Nenhum resultado encontrado.';
                $err = 'Não há venda com o id informado.';
                
                $this->enviarResposta(
                    codigo: 404,
                    mensagem: $msg,
                    dados: null,
                    erros: $err
                );
            }

        // Em caso de erro interno na realização da operação
        } catch (PDOException $e) {
            $msg = 'Não foi possível realizar a operação';
            
            $this->enviarResposta(
                codigo: 500,
                mensagem: $msg,
                dados: null,
                erros: $e->getMessage()
            );
        }

    }
    public function criar($d)
    {
        try {
            $this->verificarDados($d);

            $cliente = new Cliente(
                (int) $d['cliente']['id'],
                null,
                 null,
                 null
            );

            $endereco = new Endereco(
                (int) $d['endereco']['id'],
                 null,
                 null,
                 null,
                 null,
                 null,
                 null
            );


            $venda = new Venda(
                null,
                (float) $d['descontos'] ?? null,
                $d['forma_pagamento'] ?? null,
                $cliente,
                $endereco
            );

            foreach ( $d['itens'] as $it ) {
                $this->verificarDadosVariacao($it );
                
                $id_variacao = (int) $it['variacao']['id'];
                $quantidade = (int) $it['quantidade'];

                $v = $this->variacaoDao->buscarPeloId( $id_variacao );

                if ( $v ) {
                    $variacao = new Variacao(
                        (int) $v['id'],
                        null,
                        null,
                        null,
                        (float) $v['preco'],
                        (int) $v['estoque'],
                        null
                    );
                }

                $venda->addItens(
                    $variacao,
                    $quantidade
                );
            }

            $venda->validar();

            $d['valor_total'] = $venda->getValorTotal();
            $d['valor_frete'] = $venda::VALOR_FRETE;

            // Em caso de sucesso na operação
            if ($this->dao->salvar($d)) {
               if ( $this->exibir_detalhes ) {
                   $msg = 'Salvo com sucesso! Id gerado: ' . $d['id'];
                   
                   $this->enviarResposta(
                       codigo: 200,
                       mensagem: $msg
                   );
               } else {
                   $this->enviarResposta(
                       codigo: 204
                   );
               }

            // Em caso da operação não afetar linhas
            } else {
                $msg = 'A operação não teve efeito.';
                
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: $msg
                );
            }

        // Em caso de erros relacionados a lógica de negócio
        } catch (DominioException $e) {
            $msg = 'Os dados fornecidos não puderam ser processados.';
            
            $this->enviarResposta(
                codigo: 400,
                mensagem: $msg,
                dados: null,
                erros: $e->getMessage()
            );
            
        // Em caso de erro interno na realização da operação
        } catch (PDOException $e) {
            $msg =  'Não foi possível realizar a operação.';
            
            $this->enviarResposta(
                codigo: 500,
                mensagem: $msg,
                dados: null,
                erros: $e->getMessage()
            );
        }
    }
   
    public function excluir($id)
    {

        try {
            $this->verificarId($id);

            // Em caso de sucesso na operação
            if ($this->dao->remover($id)) {
                $this->enviarResposta(
                    codigo: 204
                );

            // Em caso da operação não afetar linhas
            } else {
                $msg = 'A operação não teve efeito.';
                $err = 'Não há venda com o id informado.';
                
                $this->enviarResposta(
                    codigo: 404,
                    mensagem: $msg,
                    dados: null,
                    erros: $err
                );
            }

            // Em caso de erro interno na realização da operação
        } catch (PDOException $e) {
            $msg =  'Não foi possível realizar a operação.';
            
            $this->enviarResposta(
                codigo: 500,
                mensagem: $msg,
                dados: null,
                erros: $e->getMessage()
            );
        }
    }

    /**
     * Validação dos tipos de dado de entrada
     * @param mixed $d
     * @return void
     */
    private function verificarDados( $d )
    {
        $erros = [];
        
        // Verifica se o cliente foi informado e se ele possui um id numérico
        if ( isset($d['cliente'])) {
            if (!isset($d['cliente']['id'])) {
                $erros[] = 'O id do cliente não foi informado.';
            } else if (!is_numeric($d['cliente']['id'])) {
                $erros[] = 'O id do cliente informado não é numérico.';
            } 
        } else {
            $erros[] = 'O cliente não foi informado.';
        }

        // Verifica se o endereco foi informado e se ele possui um id numérico
        if ( isset($d['endereco'])) {
            if (!isset($d['endereco']['id'])) {
                $erros[] = 'O id do endereco não foi informado.';
            } else if (!is_numeric($d['endereco']['id'])) {
                $erros[] = 'O id do endereco informado não é numérico.';
            } 
        } else {
            $erros[] = 'O endereco não foi informado.';
        }

        // Verifica se o descontos é numérico
        if ( isset($d['descontos'])) {
             if (!is_numeric($d['descontos'] )) {
                $erros[] = 'O valor de descontos informado não é numérico.';
            } 
        }


        if (!empty($erros)) {
            $msg = 'Operação não realizada.';
            
            $this->enviarResposta(
                codigo: 400,
                mensagem: $msg,
                dados: null,
                erros: $erros
            );
        }
        
    }
    
    /**
     * Verificação do campo id
     * @param mixed $d
     * @return void
     */
    private function verificarId($id) {
        $erros = [];
        
        // Verifica se o id informado é numérico
        if (! $id ) {
            $erros[] = 'O id não foi informado.';
        } else if (!is_numeric($id)) {
            $erros[] = 'O id informado não é numérico.';
        }
        
        if (!empty($erros)) {
            $msg = 'Operação não realizada.';
            
            $this->enviarResposta(
                codigo: 400,
                mensagem: $msg,
                dados: null,
                erros: $erros
            );
        }
    }
    
    private function verificarDadosVariacao($d) {
        $erros = [];
        
        // Verifica se o id informado é numérico
        if (!isset($d['variacao']['id'])) {
            $erros[] = 'O id da variação não foi informado.';
        } else if (!is_numeric($d['variacao']['id'])) {
            $erros[] = 'O id da variação informado não é numérico.';
        }
        
        // Verifica se a quantidade é numérica
        if ( isset($d['quantidade'])) {
            if (!is_numeric($d['quantidade'] )) {
               $erros[] = 'A quantidade informado não é numérica.';
           } 
       }

        if (!empty($erros)) {
            $msg = 'Operação não realizada.';
            
            $this->enviarResposta(
                codigo: 400,
                mensagem: $msg,
                dados: null,
                erros: $erros
            );
        }
    }

    private function enviarResposta($codigo, $mensagem = null, $dados = null, $erros = null)
    {
        
        http_response_code($codigo);
        
        if ($dados) {
            exit(json_encode(
                $dados, 
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            ));
        }

        if ($mensagem) {
            if ( $this->exibir_detalhes && $erros ) {
                exit(
                    json_encode(
                        [
                            'mensagem' => $mensagem,
                            'erros' => $erros,
                        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            } else {
                exit(json_encode(
                    ['mensagem' => $mensagem], 
                    JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE
                ));
            }
        }

        exit();
    }
}

?>