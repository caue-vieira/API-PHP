<?php
class TurnoService {

    private TurnoRepository $turnoRepository;

    public function criarTurno(string $nome): array {
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