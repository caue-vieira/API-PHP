<?php
interface IUsuarioService {
    public function criarUsuario(string $nome, string $genero, string $email, string $senha): Usuario;
    public function buscaUsuarios(): array;
}