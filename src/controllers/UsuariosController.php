<?php
require_once __DIR__ . "/../interfaces/services/IUsuarioService.php";
require_once __DIR__ . "/../interfaces/repository/IUsuarioRepository.php";
require_once __DIR__ . "/../services/UsuarioService.php";
require_once __DIR__ . "/../repository/UsuarioRepository.php";
require_once __DIR__ . "/../errors/emptyFieldException.php";
require_once __DIR__ . "/../errors/notFoundException.php";
require_once __DIR__ . "/../errors/unexpectedErrorException.php";

class UsuariosController {
    private IUsuarioService $usuarioService;

    public function __construct() {
        $this->usuarioService = new UsuarioService(new UsuarioRepository());
    }

    public function cadastraUsuario() {
        header("Content-Type: application/json");

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $this->usuarioService->criarUsuario($data['nome'], $data['genero'], $data['email'], $data['senha']);
            echo json_encode(['message' => "Usuario cadastrado com sucesso"]);
        } catch(EmptyFieldException | UnexpectedErrorException $e) {
            http_response_code($e->getCode());
            echo json_encode(['message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno do servidor']);
        }
    }

    public function buscarUsuarios() {
        header("Content-Type: application/json");

        try {
            $usuarios = $this->usuarioService->buscaUsuarios();
            echo json_encode($usuarios);
        } catch(NotFoundException | UnexpectedErrorException $e) {
            http_response_code($e->getCode());
            echo json_encode(['message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno do servidor']);
        }
    }
}