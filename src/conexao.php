<?php

// Arquivo de Configuração da conexão com o banco de dados

const HOST = "";        // Preencher com o host local; 
const USER = "";        // Preencher com o usuário local
const PASSWORD = "";    // Preencher com a senha local

function conectar () {
    $dbname = "acme_fitness";
    $dsn = "mysql:host=".HOST.";dbname=$dbname;charset=utf8";

    try {
        $pdo = new PDO(
            $dsn, USER, PASSWORD
        );
        $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit( json_encode('Falha na Conexão', JSON_UNESCAPED_UNICODE) );
    }
    
    return $pdo; 
}
?>
