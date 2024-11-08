<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controllers/LivroController.php';

use PHPUnit\Framework\TestCase;

class LivroControllerTest extends TestCase
{

    private $livroController;
    private $livroMock;
    
    protected function setUp(): void
    {
        // Mock the Livro model
        $this->livroMock = $this->createMock(Livro::class);
        // Instantiate LivroController with the mocked Livro model
        $this->livroController = new LivroController($this->livroMock);
    }


    public function testGetAllByUserIdWithValidUserId()
    {
        // Mock the request data
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $data = json_encode(['usuario_id' => 1]);
        file_put_contents("php://input", $data);

        // Mock the getAllByUserId method to return a non-empty result
        $this->livroMock->method('getAllByUserId')
            ->with(1)
            ->willReturn([
                ['id' => 1, 'title' => 'Book 1', 'author' => 'Author 1'],
                ['id' => 2, 'title' => 'Book 2', 'author' => 'Author 2']
            ]);

        // Capture the output
        ob_start();
        $this->livroController->getAllByUserId();
        $output = ob_get_clean();

        // Assert status code and response
        $this->assertStringContainsString('200', http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('Book 1', $output);
    }


}