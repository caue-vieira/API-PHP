<?php
namespace App\Interfaces\Services;

use App\Models\Usuario;

interface IUsuarioService {
    public function criarUsuario(string $nome, string $trilha, string $email): string;
    public function buscaUsuarios(): array;
}