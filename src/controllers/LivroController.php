<?php


require_once __DIR__ . '/../models/Livro.php';

class LivroController
{
    private $livro;

    public function __construct($db)
    {
        $this->livro = new Livro($db);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->titulo) && isset($data->autor) && isset($data->usuario_id)) {
            try {
                $result = $this->livro->create($data->titulo, $data->autor, $data->usuario_id, $data->urlimagem ?? null, $data->comentario ?? null, $data->nota ?? null, $data->status ?? null);
                http_response_code(200);
                echo json_encode(["message" => "Livro cadastrado com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao cadastrar o livro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->titulo) && isset($data->autor)) {
            try {
                $result = $this->livro->update($data->id, $data->titulo, $data->autor, $data->urlimagem ?? null, $data->comentario ?? null, $data->nota ?? null, $data->status ?? null);
                if ($result) {
                    http_response_code(200);
                    echo json_encode(["message" => "Livro atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar o livro."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar o livro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id)) {
            try {
                $result = $this->livro->delete($data->id);
                if ($result) {
                    http_response_code(200);
                    echo json_encode(["message" => "Livro deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar o livro."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o livro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function getAllByUserId()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->usuario_id)) {
            try {
                $books = $this->livro->getAllByUserId($data->usuario_id);
                if ($books) {
                    http_response_code(200);
                    echo json_encode($books);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Nenhum livro encontrado para este usuário."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar livros."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}