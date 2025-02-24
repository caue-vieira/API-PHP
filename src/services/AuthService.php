<?php
namespace App\Services;

use App\Errors\LoginErrorException;
use App\Errors\UnexpectedErrorException;
use App\Interfaces\Repository\IUsuarioRepository;
use App\Interfaces\Services\IAuthService;
use App\Middleware\JWT;
use Exception;

class AuthService implements IAuthService {
    private IUsuarioRepository $usuarioRepository;

    public function __construct(IUsuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function login(string $usuario_login, string $senha): array | bool {
        try {
            $usuario = $this->usuarioRepository->login($usuario_login, $senha);
            if(!$usuario) {
                throw new LoginErrorException("Usuário ou senha inválidos");
            }

            $payload = [
                "sub" => $usuario['id'],
                "user" => $usuario,
                "exp" => time() + 60 * 60
            ];

            $token = JWT::generateJWT($payload, "chave_super_segura");

            setcookie("jwt", $token, [
                "expires" => time() + 60 * 60,
                "path" => "/",
                "httponly" => true,
                "secure" => isset($_SERVER['HTTPS']),
                "samesite" => "Strict",
            ]);

            return $usuario;
        } catch(LoginErrorException $e) {
            throw $e;
        } catch(Exception $e) {
            throw new UnexpectedErrorException($e->getMessage());
        }
    }
}