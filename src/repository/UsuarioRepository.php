<?php
namespace App\Repository;

use App\Database\Database;
use App\Interfaces\Repository\IUsuarioRepository;
use App\Models\Usuario;
use App\Config\UUID;

class UsuarioRepository implements IUsuarioRepository {

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
}