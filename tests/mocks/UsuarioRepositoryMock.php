<?php
namespace Tests\Mocks;

use App\Config\UUID;
use App\Database\Database;
use App\Interfaces\Repository\IUsuarioRepository;
use App\Models\Usuario;

class UsuarioRepositoryMock implements IUsuarioRepository {

    public function criarUsuario(string $nome, string $trilha, string $email): string {
        $novoUsuario = new Usuario(UUID::generateUuidV4(), $nome, $trilha, $email);
        return $novoUsuario->getId();
    }

    public function buscaUsuarios(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM tb_usuarios");
        $usuarios = $stmt->fetchAll();

        return $usuarios;
    }

    public function login(string $nome_usuario, string $senha): array | bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM tb_usuarios WHERE login = '{$nome_usuario}' AND senha = '{$senha}'");
        $usuario = $stmt->fetch();

        return $usuario;
    }
}