<?php
namespace App\Models;

class Usuario {
    private ?string $id;
    private string $nome;
    private string $trilha;
    private string $email;

    public function __construct(?string $id = null, string $nome, string $trilha, string $email) {
        $this->id = $id;
        $this->nome = $nome;
        $this->trilha = $trilha;
        $this->email = $email;
    }

    public function getId(): ?string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getTrilha(): string {
        return $this->trilha;
    }

    public function setTrilha(string $trilha): void {
        $this->trilha = $trilha;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }
}