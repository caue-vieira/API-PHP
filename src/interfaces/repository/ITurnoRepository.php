<?php
interface ITurnoRepository {
    public function criarTurno(string $nome): Turno;
    public function buscaTurnos(): array;
}