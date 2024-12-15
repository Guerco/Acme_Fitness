    <?php

require_once __DIR__ . '/../dao/EnderecoDao.php';
require_once __DIR__ . '/../model/Endereco.php';
require_once __DIR__ . '/../model/DominioException.php';

class EnderecoController
{

    /**
     * @param EnderecoDao $dao
     * @param bool $exibir_detalhes Define se detalhes adicionais sobre as exceções são exibidos
     */
    public function __construct(
        private EnderecoDao $dao,
        private $exibir_detalhes = false
    ) {}

    public function listar() {
        try {
            $enderecos = $this->dao->buscarTudo();

            // Em caso de sucesso na operação
            if ($enderecos) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $enderecos
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
        $this->verificariD($d);

        $id = (int) $d['id'];

        try {
            $endereco = $this->dao->buscarPeloId($id);

            // Em caso de sucesso na operação
            if ($endereco) {
                $this->enviarResposta(
                    codigo: 200,
                    mensagem: null,
                    dados: $endereco
                );

            // Em caso da operação não possuir retorno
            } else {
                $msg = 'Nenhum resultado encontrado.';
                $err = 'Não há endereco com o id informado.';
                
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
            $endereco = new Endereco(
                null,
                $d['logradouro'] ?? null,
                $d['cidade'] ?? null,
                $d['bairro'] ?? null,
                $d['numero'] ?? null,
                $d['cep'] ?? null,
                $d['complemento'] ?? null
            );

            $endereco->validar();

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

            $endereco = new Endereco(
                (int) $d['id'],
                $d['logradouro'] ?? null,
                $d['cidade'] ?? null,
                $d['bairro'] ?? null,
                $d['numero'] ?? null,
                $d['cep'] ?? null,
                $d['complemento'] ?? null
            );

            $endereco->validar();

            // Em caso de sucesso na operação
            if ($this->dao->alterar($d)) {
                $this->enviarResposta(
                    codigo: 204
                );

            // Em caso da operação não afetar linhas
            } else {
                $msg = 'A operação não teve efeito.';
                $err = 'Não há endereco com o id informado ou nenhuma alteração foi feita.';
                
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
                $err = 'Não há endereco com o id informado.';
                
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