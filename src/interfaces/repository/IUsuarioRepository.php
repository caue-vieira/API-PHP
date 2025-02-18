<?php
interface IUsuarioRepository {
    public function criarUsuario(string $nome, string $genero, string $email, string $senha): Usuario;
    public function buscaUsuarios(): array;
}