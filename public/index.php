<?php
session_start();

require_once __DIR__ . '/../Controllers/ImovelController.php';


$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    'GET'  => [
        '/' => ['ImovelController', 'listar'],
        '/imoveis/(\d+)/excluir' => ['ImovelController', 'excluir'],
        '/imoveis/(\d+)/editar' => ['ImovelController', 'obterPorId'],

    ],
    'POST' => [
        '/imovel'       => ['ImovelController', 'cadastrar'],
        '/imoveis/(\d+)' => ['ImovelController', 'editar'],
    ],
];

$found = false;

foreach ($routes[$method] as $route => $handler) {
    $pattern = '#^' . $route . '$#';
    if (preg_match($pattern, $uri, $matches)) {
        $found = true;
        array_shift($matches);
        $controller = new $handler[0]();
        call_user_func_array([$controller, $handler[1]], $matches);
        break;
    }
}

if (!$found) {
    http_response_code(404);
    echo "404 - Página não encontrada";
}
