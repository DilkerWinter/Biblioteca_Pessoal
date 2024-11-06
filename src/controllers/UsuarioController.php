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

    
}