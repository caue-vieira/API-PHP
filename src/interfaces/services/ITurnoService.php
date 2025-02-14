<?php
interface ITurnoService {
    public function criarTurno(string $nome): Turno;
    public function buscaTurnos(): array;
}