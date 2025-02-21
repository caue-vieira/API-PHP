<?php
namespace App\Interfaces\Repository;

use App\Models\Usuario;

interface IUsuarioRepository {
    public function criarUsuario(string $nome, string $trilha, string $email): string;
    public function buscaUsuarios(): array;
}