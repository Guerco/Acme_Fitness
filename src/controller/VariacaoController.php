<?php

require_once __DIR__ . '/../dao/VariacaoDao.php';
require_once __DIR__ . '/../model/Variacao.php';
require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../model/DominioException.php';

class VariacaoController
{

    /**
     * @param VariacaoDao $dao
     * @param bool $exibir_detalhes Define se detalhes adicionais sobre as exceções são exibidos
     */
    public function __construct(
        private VariacaoDao $dao,
        private $exibir_detalhes = false
    ) {}

    public function listar() {
        try {
            $variacaos = $this->dao->buscarTudo();

            // Em caso de sucesso na operação
            if ($variacaos) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $variacaos
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
        try {
            $this->verificarId($id);
            $variacao = $this->dao->buscarPeloId($id);

            // Em caso de sucesso na operação
            if ($variacao) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $variacao
                );

            // Em caso da operação não possuir retorno
            } else {
                $msg = 'Nenhum resultado encontrado.';
                $err = 'Não há variacao com o id informado.';
                
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

            $produto = new Produto(
                (int) $d['produto']['id'],
                null,
                null,
                null,
                null,
                null
            );

            $variacao = new Variacao(
                null,
                $d['tamanho'] ?? null,
                $d['peso'] ?? null,
                $d['cor'] ?? null,
                (float) $d['preco'] ?? null,
                (int) $d['estoque'] ?? null,
                $produto
            );

            $variacao->validar();

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
    public function atualizar($id, $d)
    {
        try {
            $this->verificarId( $id );

            $this->verificarDados($d);

            $produto = new Produto(
                (int) $d['produto']['id'],
                null,
                null,
                null,
                null,
                null
            );

            $variacao = new Variacao(
                (int) $id,
                $d['tamanho'] ?? null,
                $d['peso'] ?? null,
                $d['cor'] ?? null,
                (float) $d['preco'] ?? null,
                (int) $d['estoque'] ?? null,
                $produto
            );

            $variacao->validar();

            // Em caso de sucesso na operação
            if ($this->dao->alterar($d)) {
                $this->enviarResposta(
                    codigo: 204
                );

            // Em caso da operação não afetar linhas
            } else {
                $msg = 'A operação não teve efeito.';
                $err = 'Não há variacao com o id informado ou nenhuma alteração foi feita.';
                
                $this->enviarResposta(
                    codigo: 404,
                    mensagem: $msg,
                    dados: null,
                    erros: $err
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
                $err = 'Não há variacao com o id informado.';
                
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
        
        // Verifica se o produto foi informado e se ele possui um id numérico
        if ( isset($d['produto'])) {
            if (!isset($d['produto']['id'])) {
                $erros[] = 'O id do produto não foi informado.';
            } else if (!is_numeric($d['produto']['id'])) {
                $erros[] = 'O id do produto informado não é numérico.';
            } 
        } else {
            $erros[] = 'O produto não foi informado.';
        }

        // Verifica se o preco é numérico
        if ( isset($d['preco'])) {
             if (!is_numeric($d['preco'] )) {
                $erros[] = 'O preco informado não é numérico.';
            } 
        }

        // Verifica se o estoque é numérico
        if ( isset($d['estoque'])) {
             if (!is_numeric($d['estoque'] )) {
                $erros[] = 'O estoque informado não é numérico.';
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