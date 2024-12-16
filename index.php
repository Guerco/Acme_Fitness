<?php

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__.'/rotas/rotas.php';
require_once __DIR__.'/src/conexao.php';

$url = $_SERVER[ 'REQUEST_URI' ];
$metodo = $_SERVER[ 'REQUEST_METHOD'];

$input_json = file_get_contents('php://input');
$input = json_decode (file_get_contents('php://input') , true);

$pdo = conectar();

const EXIBIR_DETALHES = false; // Configura os controladores para exibirem ou não detalhes adicionais nas respostas


processarRequisicao( $metodo, $url, $input, $pdo, EXIBIR_DETALHES);


?>