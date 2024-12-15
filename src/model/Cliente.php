<?php

require_once __DIR__.'/DominioException.php';

class Cliente {

    /**
     * @param int $id
     * @param string $nome
     * @param string $cpf
     * @param string $data_nascimento
     */
    public function __construct(
        private ?int $id,
        private ?string $nome,
        private ?string $cpf,
        private ?string $data_nascimento
    ) {}

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getNome(): ?string {
        return $this->nome;
    }

    public function getCpf(): ?string {
        return $this->cpf;
    }

    public function getDataNascimento(): ?string {
        return $this->data_nascimento;
    }

    // Validação
    public function validar() {
        $erros = [];

        // Verifica se o id, caso atribuido, seja um número não negativo
        if ( $this->id  ) {
            if ( $this->id < 0 )
                $erros[] = 'O id deve ser inteiro e não negativo.';
        }

        // Verifica se o nome foi preenchido
        if ( empty( $this->nome ) ) {
            $erros[] = 'O nome é obrigatório.';
        } 
        
        // Verifica se o cpf foi preenchidos e se segue o formato definido
        if ( empty( $this->cpf ) ) {
            $erros[] = 'O cpf é obrigatório.';
        } else if ( ! $this->validarCpf($this->cpf) ) {
            $erros[] = 'O cpf deve estar no formato XXX.XXX.XXX-XX';
        }
        
        // Verifica se a data de nascimento foi preenchida, se segue o formato definido e se é válida
        if ( empty( $this->data_nascimento ) ) {
            $erros[] = 'A  data de nascimento é obrigatória.';
        } else if ( ! $this->validarData($this->data_nascimento) ) {
            $erros[] = 'A data de nascimento deve ser uma data válida no formato AAAA-MM-DD';
        }

        if ( $erros ) {
            $erros_json = json_encode( $erros, JSON_UNESCAPED_UNICODE );
            throw new DominioException($erros_json);
        }
    }

    private function validarCpf ( $cpf ) {
        $formato = '/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/';

        return preg_match($formato, $cpf);
    }

    private function validarData ( $data ) {
        $formato = '/^\d{4}\-\d{2}\-\d{2}$/';

        if ( ! preg_match($formato, $data) )
            return false;

        $ano = explode('-', $data)[0];
        $mes = explode('-', $data)[1];
        $dia = explode('-', $data)[2];

        return checkdate($mes, $dia, $ano);
    }
}

?>
