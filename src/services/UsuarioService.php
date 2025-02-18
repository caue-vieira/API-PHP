<?php
require_once __DIR__ . "/../interfaces/services/IUsuarioService.php";

class UsuarioService implements IUsuarioService {
    private IUsuarioRepository $usuarioRepository;

    public function __construct(IusuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function criarUsuario(string $nome, string $genero, string $email, string $senha): Usuario {
        try {
            if(empty($nome)) {
                throw new EmptyFieldException("O nome do usuario não pode estar vazio");
            }
            return $this->usuarioRepository->criarUsuario($nome, $genero, $email, $senha);
        } catch(Exception $e) {
            throw new UnexpectedErrorException("Ocorreu um erro inesperado ao cadastrar o usuario");
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