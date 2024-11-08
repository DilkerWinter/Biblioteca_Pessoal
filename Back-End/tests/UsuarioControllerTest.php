<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controllers/UsuarioController.php';

use PHPUnit\Framework\TestCase;

class UsuarioControllerTest extends TestCase
{

    private $usuarioController;
    private $usuarioMock;

    protected function setUp(): void
    {
        $this->usuarioMock = $this->createMock(Usuario::class);

        $this->usuarioController = new UsuarioController($this->usuarioMock);
    }

    public function testFindByIdReturnsUserWhenUserExists()
    {
        $userId = 2;
        $userData = ["id" => $userId, "nome" => "Bruno Winter"];

        $this->usuarioMock->method('findById')->with($userId)->willReturn($userData);

        $_SERVER["CONTENT_TYPE"] = "application/json";
        file_put_contents("php://input", json_encode(["id" => $userId]));

        ob_start();
        $this->usuarioController->findById();
        $output = ob_get_clean();



        $this->assertJsonStringEqualsJsonString(json_encode($userData), $output);
    }
}
