<?php

// Arquivo de Configuração da conexão com o banco de dados

function conectar () {
    // Preencher as informações locais do banco de dados
    $host = ""; 
    $user = "";
    $password = "";
    $dbname = "acme_fitness";
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try {
        $pdo = new PDO(
            $dsn, $user, $password
        );
        $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit( json_encode('Falha na Conexão', JSON_UNESCAPED_UNICODE) );
    }
    
    return $pdo; 
}
?>
