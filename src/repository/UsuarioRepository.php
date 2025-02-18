<?php
require_once __DIR__ . "/../interfaces/repository/IUsuarioRepository.php";
require_once __DIR__ . "/../models/Usuario.php";

class UsuarioRepository implements IUsuarioRepository {
    private array $usuarios = [
        ['id' => 1, 'nome' => 'Pedro', 'genero' => 'M', 'email' => 'pedro@gmail.com', 'senha' => 'pedrinhoreidelas123'],
        ['id' => 2, 'nome' => 'Lucas', 'genero' => 'M', 'email' => 'shaolinmatadordeporco@gmail.com', 'senha' => 'luquinhas'],
    ];

    public function criarUsuario(string $nome, string $genero, string $email, string $senha): Usuario {
        $novoUsuario = new Usuario(rand(3, 100), $nome, $genero, $email, $senha);
        $this->usuarios[] = [
            'id' => $novoUsuario->getId(),
            'nome' => $novoUsuario->getNome(),
            'genero' => $novoUsuario->getGenero(),
            'email' => $novoUsuario->getEmail(),
            'senha' => $novoUsuario->getSenha(),
        ];
        return $novoUsuario;
    }

    public function buscaUsuarios(): array {
        return $this->usuarios;
    }
}