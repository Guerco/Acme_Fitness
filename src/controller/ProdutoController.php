<?php

require_once __DIR__ . '/../dao/ProdutoDao.php';
require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../model/Categoria.php';
require_once __DIR__ . '/../model/DominioException.php';

class ProdutoController
{

    /**
     * @param ProdutoDao $dao
     * @param bool $exibir_detalhes Define se detalhes adicionais sobre as exceções são exibidos
     */
    public function __construct(
        private ProdutoDao $dao,
        private $exibir_detalhes = false
    ) {}

    public function listar() {
        try {
            $produtos = $this->dao->buscarTudo();

            // Em caso de sucesso na operação
            if ($produtos) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $produtos
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
    public function buscar($d) {
        $this->verificarId($d);

        $id = (int) $d['id'];

        try {
            $produto = $this->dao->buscarPeloId($id);

            // Em caso de sucesso na operação
            if ($produto) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $produto
                );

            // Em caso da operação não possuir retorno
            } else {
                $msg = 'Nenhum resultado encontrado.';
                $err = 'Não há produto com o id informado.';
                
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

            $categoria = new Categoria(
                (int) $d['categoria']['id'],
                null,
                null
            );

            $produto = new Produto(
                null,
                $d['nome'] ?? null,
                $d['imahem_path'] ?? null,
                $d['descricao'] ?? null,
                $d['data_cadastro'] ?? null,
                $categoria
            );

            $produto->validar();

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
    public function atualizar($d)
    {
        try {
            $this->verificarDados($d, true);

            $categoria = new Categoria(
                (int) $d['categoria']['id'],
                null,
                null
            );

            $produto = new Produto(
                (int) $d['id'],
                $d['nome'] ?? null,
                $d['imahem_path'] ?? null,
                $d['descricao'] ?? null,
                $d['data_cadastro'] ?? null,
                $categoria
            );

            $produto->validar();

            // Em caso de sucesso na operação
            if ($this->dao->alterar($d)) {
                $this->enviarResposta(
                    codigo: 204
                );

            // Em caso da operação não afetar linhas
            } else {
                $msg = 'A operação não teve efeito.';
                $err = 'Não há produto com o id informado ou nenhuma alteração foi feita.';
                
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
    public function excluir($d)
    {

        try {
            $this->verificarId($d);

            $id = (int) $d['id'];

            // Em caso de sucesso na operação
            if ($this->dao->remover($id)) {
                $this->enviarResposta(
                    codigo: 204
                );

            // Em caso da operação não afetar linhas
            } else {
                $msg = 'A operação não teve efeito.';
                $err = 'Não há produto com o id informado.';
                
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
    private function verificarDados($d, $verificar_id = false)
    {
        $erros = [];

        if ($verificar_id) {
            // Verifica se o id informado é numérico
            if (!isset($d['id'])) {
                $erros[] = 'O id não foi informado.';
            } else if (!is_numeric($d['id'])) {
                $erros[] = 'O id informado não é numérico.';
            }
        }

        if ( isset($d['categoria'])) {
            if (!isset($d['categoria']['id'])) {
                $erros[] = 'O id da categoria não foi informado.';
            } else if (!is_numeric($d['categoria']['id'])) {
                $erros[] = 'O id da categoria informado não é numérico.';
            } 
        } else {
            $erros[] = 'A categoria não foi informada.';

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
    
    private function verificarId($d) {
        $erros = [];
        
        // Verifica se o id informado é numérico
        if (!isset($d['id'])) {
            $erros[] = 'O id não foi informado.';
        } else if (!is_numeric($d['id'])) {
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