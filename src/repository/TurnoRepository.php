<?php
require_once __DIR__ . "/../interfaces/repository/ITurnoRepository.php";
require_once __DIR__ . "/../models/Turno.php";

class TurnoRepository implements ITurnoRepository {
    private array $turnos = [
        ["id" => 1, "nome" => "Turno A"],
        ["id" => 2, "nome" => "Turno B"]
    ];

    public function criarTurno(string $nome): Turno {
        $novoTurno = new Turno(rand(3, 100), $nome);
        $this->turnos[] = ['id' => $novoTurno->getId(), 'nome' => $novoTurno->getNome()];
        return $novoTurno;
    }

    public function buscaTurnos(): array {
        return $this->turnos;
    }
}