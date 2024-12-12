<?php

// Arquivo de Configuração da conexão com o banco de dados

function conectar () {
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
    } catch (PDOException $e) {
        die("Falha na Conexão: " . $e->getMessage());
    }
    
    return $pdo; 
}
?>
