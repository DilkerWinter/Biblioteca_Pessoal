<?php


require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
    private $usuario;

    public function __construct($db)
    {
        $this->usuario = new Usuario($db);
    }

    public function create($dados)
    {
        $data = json_decode(file_get_contents("php://input"));
        var_dump($_POST);
        if (isset($data->nome) && isset($data->senha)) {
            try {
                $result = $this->usuario->create($data->nome, $data->senha);
                if ($result === false) {
                    http_response_code(409);
                    echo json_encode(["message" => "Nome de usuário já cadastrado."]);
                    return;
                }
                http_response_code(200);
                echo json_encode(["message" => "Cadastro feito com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao cadastrar."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->nome) && isset($data->senha)) {
            try {
                $userId = $this->usuario->login($data->nome, $data->senha);
                if ($userId !== false) {
                    http_response_code(200);
                    echo json_encode(["message" => "Login bem-sucedido.", "user_id" => $userId]);
                } else {
                    http_response_code(401);
                    echo json_encode(["message" => "Nome de usuário ou senha incorretos."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao fazer login."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->nome) && isset($data->senha)) {
            try {
                $result = $this->usuario->update($data->id, $data->nome, $data->senha);
                if ($result) {
                    http_response_code(200);
                    echo json_encode(["message" => "Usuário atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar usuário."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar usuário."]);
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
                $result = $this->usuario->delete($data->id);
                if ($result) {
                    http_response_code(200);
                    echo json_encode(["message" => "Usuário deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar usuário."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function findById()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id)) {
            try {
                $user = $this->usuario->findById($data->id);
                if ($user) {
                    http_response_code(200);
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Usuário não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}
