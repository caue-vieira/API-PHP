<?php
namespace App\Interfaces\Services;

interface IAuthService {
    public function login(string $usuario_login, string $senha): array | bool;
}