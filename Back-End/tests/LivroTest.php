<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controllers/LivroController.php';

use PHPUnit\Framework\TestCase;

class LivroTest extends TestCase
{
    private $conn;
    private $livro;

    protected function setUp(): void
    {
        $this->conn = new PDO('pgsql:host=localhost;dbname=phpprova', 'postgres', '123');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->livro = new Livro($this->conn);
    }

    protected function tearDown(): void
    {
        $this->conn->exec("DELETE FROM livro");
    }

    public function testCreateLivro()
    {
        $titulo = "Livro Teste";
        $autor = "Autor Teste";
        $usuario_id = 1; 
        $urlimagem = "http://exemplo.com/imagem.jpg";
        $comentario = "Excelente livro!";
        $nota = 5;
        $status = "lido";

        $resultado = $this->livro->create($titulo, $autor, $usuario_id, $urlimagem, $comentario, $nota, $status);

        $this->assertTrue($resultado, "Erro ao criar livro.");

        $checkSql = "SELECT COUNT(*) FROM livro WHERE titulo = :titulo";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':titulo', $titulo);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        $this->assertEquals(1, $count, "Livro não foi inserido no banco de dados.");
    }

    public function testUpdateLivro()
    {
        $tituloOriginal = "Livro Teste";
        $autorOriginal = "Autor Teste";
        $usuario_id = 1;
        $urlimagemOriginal = "http://exemplo.com/imagem.jpg";
        $comentarioOriginal = "Excelente livro!";
        $notaOriginal = 5;
        $statusOriginal = "lido";
        $this->livro->create($tituloOriginal, $autorOriginal, $usuario_id, $urlimagemOriginal, $comentarioOriginal, $notaOriginal, $statusOriginal);

        $livroId = $this->conn->lastInsertId();

        $novoTitulo = "Livro Teste Atualizado";
        $novoAutor = "Autor Teste Atualizado";
        $novaUrlImagem = "http://exemplo.com/imagem_atualizada.jpg";
        $novoComentario = "Muito bom!";
        $novaNota = 4;
        $novoStatus = "em andamento";

        $resultado = $this->livro->update($livroId, $novoTitulo, $novoAutor, $novaUrlImagem, $novoComentario, $novaNota, $novoStatus);

        $this->assertTrue($resultado, "Erro ao atualizar livro.");

        $livroAtualizado = $this->livro->getAllByUserId($usuario_id);
        $livroEncontrado = null;

        foreach ($livroAtualizado as $livro) {
            if ($livro['id'] == $livroId) {
                $livroEncontrado = $livro;
                break;
            }
        }

        $this->assertNotNull($livroEncontrado, "Livro não encontrado após atualização.");
        $this->assertEquals($novoTitulo, $livroEncontrado['titulo'], "Título não foi atualizado.");
        $this->assertEquals($novoAutor, $livroEncontrado['autor'], "Autor não foi atualizado.");
        $this->assertEquals($novaNota, $livroEncontrado['nota'], "Nota não foi atualizada.");
        $this->assertEquals($novoStatus, $livroEncontrado['status'], "Status não foi atualizado.");
    }

    public function testDeleteLivro()
    {
        $titulo = "Livro para Excluir";
        $autor = "Autor para Excluir";
        $usuario_id = 1;
        $urlimagem = "http://exemplo.com/imagem.jpg";
        $comentario = "Livro para exclusão.";
        $nota = 4;
        $status = "lido";
        $this->livro->create($titulo, $autor, $usuario_id, $urlimagem, $comentario, $nota, $status);

        $livroId = $this->conn->lastInsertId();

        $resultado = $this->livro->delete($livroId);

        $this->assertTrue($resultado, "Erro ao deletar livro.");

        $livros = $this->livro->getAllByUserId($usuario_id);
        $livroDeletado = null;

        foreach ($livros as $livro) {
            if ($livro['id'] == $livroId) {
                $livroDeletado = $livro;
                break;
            }
        }

        $this->assertNull($livroDeletado, "Livro não foi deletado.");
    }

    public function testGetAllLivrosPorUsuario()
    {
        $usuario_id = 1; 

        $this->livro->create("Livro 1", "Autor 1", $usuario_id, "http://exemplo.com/imagem1.jpg", "Comentário 1", 5, "lido");
        $this->livro->create("Livro 2", "Autor 2", $usuario_id, "http://exemplo.com/imagem2.jpg", "Comentário 2", 4, "em andamento");

        $livros = $this->livro->getAllByUserId($usuario_id);

        $this->assertCount(2, $livros, "Número incorreto de livros para o usuário.");
        $this->assertEquals("Livro 1", $livros[0]['titulo'], "Título do livro não corresponde.");
        $this->assertEquals("Livro 2", $livros[1]['titulo'], "Título do livro não corresponde.");
    }
}