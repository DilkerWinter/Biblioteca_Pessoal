<?php


require_once __DIR__ . '/../src/config/db.php'; 
require_once __DIR__ . '/../src/controllers/UsuarioController.php'; 
require_once __DIR__ . '/../src/Router.php';

header("Content-type: application/json; charset=UTF-8");

$router = new Router();
$usuarioController = new UsuarioController($pdo);

$router->add("POST", '/registrar', [$usuarioController, 'create']);
$router->add("POST", '/login', [$usuarioController, 'login']);
$router->add("PUT", '/atualizar', [$usuarioController, 'update']);   
$router->add("DELETE", '/deletar', [$usuarioController, 'delete']); 
$router->add("GET", '/usuario', [$usuarioController, 'findById']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathItems = explode("/", trim($requestedPath, "/"));


if (count($pathItems) >= 1) {
    $requestedPath = "/" . $pathItems[0];
    if (count($pathItems) > 1) {
        $requestedPath .= "/" . $pathItems[1]; 
    }
} else {
    $requestedPath = "/"; 
}

$router->dispatch($requestedPath);

