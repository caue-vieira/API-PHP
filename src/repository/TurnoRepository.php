<?php
class TurnoRepository {
    private Turno $turno;

    private array $turnos = [
        ["id" => 1, "nome" => "Turno A"],
        ["id" => 2, "nome" => "Turno B"]
    ];

    public function criarTurno(string $nome) :array {
        $novoTurno = [
            "id" => rand(3, 100),
            "nome" => $nome,
        ];
        return $novoTurno;
    }

    public function buscaTurnos(): array {
        return $this->turnos;
    }
}