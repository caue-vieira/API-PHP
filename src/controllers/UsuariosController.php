<?php
namespace App\Controllers;

use App\Errors\InvalidDataException;
use App\Errors\LoginErrorException;
use App\Config\Http\Request;
use App\Interfaces\Services\IAuthService;
use App\Interfaces\Services\IUsuarioService;
use App\Services\AuthService;
use App\Services\UsuarioService;
use App\Errors\EmptyFieldException;
use App\Errors\NotFoundException;
use App\Errors\UnexpectedErrorException;
use App\Repository\UsuarioRepository;
use Exception;

class UsuariosController {
    private IUsuarioService $usuarioService;
    private IAuthService $authService;

    public function __construct() {
        $this->usuarioService = new UsuarioService(new UsuarioRepository());
        $this->authService = new AuthService(new UsuarioRepository());
    }

    public function cadastraUsuario(Request $request) {
        try {
            $token = $this->usuarioService->criarUsuario($request->input("nome"), $request->input('trilha'), $request->input('email'));
            http_response_code(201);
            echo json_encode(['message' => "Usuario cadastrado com sucesso", 'token' => $token]);
        } catch(Exception $e) {
            if($e instanceof EmptyFieldException || $e instanceof UnexpectedErrorException || $e instanceof InvalidDataException) {
                http_response_code($e->getCode());
                echo json_encode(['message' => $e->getMessage()]);
            }
        }
    }

    public function buscarUsuarios() {
        header("Content-Type: application/json");

        try {
            $usuarios = $this->usuarioService->buscaUsuarios();
            echo json_encode($usuarios);
        } catch(Exception $e) {
            if($e instanceof NotFoundException || $e instanceof UnexpectedErrorException) {
                http_response_code($e->getCode());
                echo json_encode(['message' => $e->getMessage()]);
            }
        }
    }

    public function login() {
        header("Content-Type: application/json");

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $usuario = $this->authService->login($data['usuario_login'], $data['usuario_senha']);
            echo json_encode($usuario);
        } catch(Exception $e) {
            if($e instanceof LoginErrorException || $e instanceof UnexpectedErrorException) {
                http_response_code($e->getCode());
                echo json_encode(['message' => $e->getMessage()]);
            }
        }
    }
}