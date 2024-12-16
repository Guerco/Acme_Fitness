<?php

require_once __DIR__ . '/../src/dao/CategoriaDao.php';
require_once __DIR__ . '/../src/dao/ClienteDao.php';
require_once __DIR__ . '/../src/dao/EnderecoDao.php';
require_once __DIR__ . '/../src/dao/ProdutoDao.php';
require_once __DIR__ . '/../src/dao/VariacaoDao.php';
require_once __DIR__ . '/../src/dao/VendaDao.php';

require_once __DIR__ . '/../src/controller/CategoriaController.php';
require_once __DIR__ . '/../src/controller/ClienteController.php';
require_once __DIR__ . '/../src/controller/EnderecoController.php';
require_once __DIR__ . '/../src/controller/ProdutoController.php';
require_once __DIR__ . '/../src/controller/VariacaoController.php';
require_once __DIR__ . '/../src/controller/VendaController.php';

function processarRequisicao($metodo, $url, $input, $pdo, $exibir_detalhes = false)
{

    if (!$metodo || !$url) {
        exit();
    }

    switch ($metodo) {
        case 'GET':
            trataGet($pdo, $url, $exibir_detalhes);
            break;
        case 'POST':
            trataPost($pdo, $url, $input, $exibir_detalhes);
            break;
        case 'PUT':
            trataPut($pdo, $url, $input, $exibir_detalhes);
            break;
        case 'DELETE':
            trataDelete($pdo, $url,  $exibir_detalhes);
            break;
        default:
            $msg = 'Método de requisição inválido';
            enviarResposta(405, $msg);
            break;

    }

}

function trataGet($pdo, $url, $exibir_detalhes)
{

    // Rota de Categorias

    // Rota de listar()
    if ($url === '/categorias' || $url === '/categorias/') {
        $dao = new CategoriaDao($pdo);
        $controller = new CategoriaController($dao, $exibir_detalhes);

        $controller->listar();
    }

    // Rota de buscar()
    else if (preg_match('/^\/categorias\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];

        $dao = new CategoriaDao($pdo);
        $controller = new CategoriaController($dao, $exibir_detalhes);

        $controller->buscar($id);
    }

    // Rota de Clientes

    // Rota de listar()
    else if ($url === '/clientes' || $url === '/clientes/') {
        $dao = new ClienteDao($pdo);
        $controller = new ClienteController($dao, $exibir_detalhes);

        $controller->listar();
    }

    // Rota de buscar()
    else if (preg_match('/^\/clientes\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];

        $dao = new ClienteDao($pdo);
        $controller = new ClienteController($dao, $exibir_detalhes);

        $controller->buscar($id);
    }

    // Rota de Endereços

    // Rota de listar()
    else if ($url === '/enderecos' || $url === '/enderecos/') {
        $dao = new EnderecoDao($pdo);
        $controller = new EnderecoController($dao, $exibir_detalhes);

        $controller->listar();
    }

    // Rota de buscar()
    else if (preg_match('/^\/enderecos\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];

        $dao = new EnderecoDao($pdo);
        $controller = new EnderecoController($dao, $exibir_detalhes);

        $controller->buscar($id);
    }

    // Rota de Produtos

    // Rota de listar()
    else if ($url === '/produtos' || $url === '/produtos/') {
        $dao = new ProdutoDao($pdo);
        $controller = new ProdutoController($dao, $exibir_detalhes);

        $controller->listar();
    }

    // Rota de buscar()
    else if (preg_match('/^\/produtos\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];

        $dao = new ProdutoDao($pdo);
        $controller = new ProdutoController($dao, $exibir_detalhes);

        $controller->buscar($id);
    }

    // Rota de Variacoes

    // Rota de listar()
    else if ($url === '/variacoes' || $url === '/variacoes/') {
        $dao = new VariacaoDao($pdo);
        $controller = new VariacaoController($dao, $exibir_detalhes);

        $controller->listar();
    }

    // Rota de buscar()
    else if (preg_match('/^\/variacoes\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];

        $dao = new VariacaoDao($pdo);
        $controller = new VariacaoController($dao, $exibir_detalhes);

        $controller->buscar($id);
    }

    // Rota de Vendas

    // Rota de listar()
    else if ($url === '/vendas' || $url === '/vendas/') {
        $dao = new VendaDao($pdo);
        $varDao = new VariacaoDao($pdo);
        $controller = new VendaController($dao, $varDao, $exibir_detalhes);

        $controller->listar();
    }

    // Rota de buscar()
    else if (preg_match('/^\/vendas\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];

        $dao = new VendaDao($pdo);
        $varDao = new VariacaoDao($pdo);
        $controller = new VendaController($dao, $varDao, $exibir_detalhes);

        $controller->buscar($id);
    } else {
        $msg = 'Recurso não encontrado.';
        enviarResposta(404, $msg);
    }
}
function trataPost($pdo, $url, $input, $exibir_detalhes)
{

    // Rota de Categorias
    if ($url === '/categorias' || $url === '/categorias/') {
        $dao = new CategoriaDao($pdo);
        $controller = new CategoriaController($dao, $exibir_detalhes);

        $controller->criar($input);
    }

    // Rota de Clientes
    else if ($url === '/clientes' || $url === '/clientes/') {
        $dao = new ClienteDao($pdo);
        $controller = new ClienteController($dao, $exibir_detalhes);

        $controller->criar($input);
    }

    // Rota de Enderecos
    else if ($url === '/enderecos' || $url === '/enderecos/') {
        $dao = new EnderecoDao($pdo);
        $controller = new EnderecoController($dao, $exibir_detalhes);

        $controller->criar($input);
    }

    // Rota de Produto
    else if ($url === '/produtos' || $url === '/produtos/') {
        $dao = new ProdutoDao($pdo);
        $controller = new ProdutoController($dao, $exibir_detalhes);

        $controller->criar($input);
    }

    // Rota de Variacoes
    else if ($url === '/variacoes' || $url === '/variacoes/') {
        $dao = new VariacaoDao($pdo);
        $controller = new VariacaoController($dao, $exibir_detalhes);

        $controller->criar($input);
    }

    // Rota de Vendas
    else if ($url === '/vendas' || $url === '/vendas/') {
        $dao = new VendaDao($pdo);
        $varDao = new VariacaoDao($pdo);
        $controller = new VendaController($dao, $varDao, $exibir_detalhes);

        $controller->criar($input);
    }

    // Url inválida
    else {
        $msg = 'Recurso não encontrado.';
        enviarResposta(404, $msg);
    }
}
function trataPut($pdo, $url, $input, $exibir_detalhes)
{
    
    // Rota de Categorias
    if (preg_match('/^\/categorias\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new CategoriaDao($pdo);
        $controller = new CategoriaController($dao, $exibir_detalhes);
        
        $controller->atualizar($id, $input);
    }
    
    // Rota de Clientes
    if (preg_match('/^\/clientes\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new ClienteDao($pdo);
        $controller = new ClienteController($dao, $exibir_detalhes);
        
        $controller->atualizar($id, $input);
    }
    
    // Rota de Enderecos
    if (preg_match('/^\/enderecos\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new EnderecoDao($pdo);
        $controller = new EnderecoController($dao, $exibir_detalhes);
        
        $controller->atualizar($id, $input);
    }
    
    // Rota de Produtos
    if (preg_match('/^\/produtos\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new ProdutoDao($pdo);
        $controller = new ProdutoController($dao, $exibir_detalhes);
        
        $controller->atualizar($id, $input);
    }
    
    // Rota de Variacoes
    if (preg_match('/^\/variacoes\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new VariacaoDao($pdo);
        $controller = new VariacaoController($dao, $exibir_detalhes);
        
        $controller->atualizar($id, $input);
    }
    
    // Url inválida
    else {
        $msg = 'Recurso não encontrado.';
        enviarResposta(404, $msg);
    }

}
function trataDelete($pdo, $url, $exibir_detalhes)
{
    // Rota de Categorias
    if (preg_match('/^\/categorias\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new CategoriaDao($pdo);
        $controller = new CategoriaController($dao, $exibir_detalhes);
        
        $controller->excluir($id);
    }
    
    // Rota de Clientes
    if (preg_match('/^\/clientes\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new ClienteDao($pdo);
        $controller = new ClienteController($dao, $exibir_detalhes);
        
        $controller->excluir($id);
    }
    
    // Rota de Enderecos
    if (preg_match('/^\/enderecos\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new EnderecoDao($pdo);
        $controller = new EnderecoController($dao, $exibir_detalhes);
        
        $controller->excluir($id);
    }
    
    // Rota de Produtos
    if (preg_match('/^\/produtos\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new ProdutoDao($pdo);
        $controller = new ProdutoController($dao, $exibir_detalhes);
        
        $controller->excluir($id);
    }
    
    // Rota de Variacoes
    if (preg_match('/^\/variacoes\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new VariacaoDao($pdo);
        $controller = new VariacaoController($dao, $exibir_detalhes);
        
        $controller->excluir($id);
    }
    
    // Rota de Vendas
    if (preg_match('/^\/vendas\/\d+\/?$/', $url)) {
        $id = (int) explode('/', $url)[2];
        
        $dao = new VendaDao($pdo);
        $varDao = new VariacaoDao($pdo);
        $controller = new VendaController($dao, $varDao, $exibir_detalhes);
        
        $controller->excluir($id);
    }
    
    // Url inválida
    else {
        $msg = 'Recurso não encontrado.';
        enviarResposta(404, $msg);
    }
}

function enviarResposta($codigo, $mensagem)
{
    http_response_code($codigo);

    exit(json_encode(
        ['mensagem' => $mensagem],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    ));
}
