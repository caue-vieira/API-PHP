<?php
namespace App\Services;

use App\Config\UUID;
use App\Errors\InvalidDataException;
use App\Interfaces\Services\IUsuarioService;
use App\Interfaces\Repository\IUsuarioRepository;
use App\Errors\EmptyFieldException;
use App\Errors\UnexpectedErrorException;
use App\Errors\NotFoundException;
use App\Models\Usuario;
use App\Validators\Validator;
use Exception;

class UsuarioService implements IUsuarioService {
    private IUsuarioRepository $usuarioRepository;

    public function __construct(IusuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function criarUsuario(string $nome, string $trilha, string $email): string {
        try {
            $usuario = new Usuario(UUID::generateUuidV4(), $nome, $trilha, $email);
            Validator::validateUser($usuario);
            return $this->usuarioRepository->criarUsuario($nome, $trilha, $email);
        } catch(Exception $e) {
            if ($e instanceof EmptyFieldException || $e instanceof InvalidDataException) {
                throw $e;
            }
            throw new UnexpectedErrorException("Ocorreu um erro inesperado ao cadastrar o usuario: " . $e->getMessage());
        }
    }

    public function buscaUsuarios(): array {
        try {
            $usuarios = $this->usuarioRepository->buscaUsuarios();
            if(empty($usuarios)) {
                throw new NotFoundException("Nenhum usuario encontrado");
            }
            return $usuarios;
        } catch(NotFoundException $e) {
            throw $e;
        } catch(Exception $e) {
            throw new UnexpectedErrorException("Ocorreu um erro inesperado ao buscar os usuarios");
        }
    }
}