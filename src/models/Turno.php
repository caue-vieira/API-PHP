<?php
class Turno {
    private ?int $id;
    private string $nome;

    public function __construct(?int $id = null, string $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }
}