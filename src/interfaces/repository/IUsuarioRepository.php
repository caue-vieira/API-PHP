<?php
namespace App\Interfaces\Repository;

use App\Models\Usuario;

interface IUsuarioRepository {
    public function criarUsuario(string $nome, string $trilha, string $email): string;
    public function buscaUsuarios(): array;
    public function login(string $nome_usuario, string $senha): array | bool;
}