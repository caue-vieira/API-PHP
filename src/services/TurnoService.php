<?php
require_once __DIR__ . "/../interfaces/services/ITurnoService.php";

class TurnoService implements ITurnoService {
    private ITurnoRepository $turnoRepository;

    public function __construct(ITurnoRepository $turnoRepository) {
        $this->turnoRepository = $turnoRepository;
    }

    public function criarTurno(string $nome): Turno {
        if(empty($nome)) {
            throw new Exception("O nome do turno não pode estar vazio");
        }
        return $this->turnoRepository->criarTurno($nome);
    }

    public function buscaTurnos(): array {
        $turnos = $this->turnoRepository->buscaTurnos();
        if(empty($turnos)) {
            throw new Exception("Nenhum turno encontrado");
        }
        return $turnos;
    }
}