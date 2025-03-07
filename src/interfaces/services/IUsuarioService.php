<?php
namespace App\Interfaces\Services;

interface IUsuarioService {
    public function criarUsuario(string $nome, string $trilha, string $email): string;
    public function buscaUsuarios(): array;
}