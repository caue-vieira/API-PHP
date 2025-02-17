<?php
require_once __DIR__ . "/../interfaces/services/ITurnoService.php";

class TurnoService implements ITurnoService {
    private ITurnoRepository $turnoRepository;

    public function __construct(ITurnoRepository $turnoRepository) {
        $this->turnoRepository = $turnoRepository;
    }

    public function criarTurno(string $nome): Turno {
        try {
            if(empty($nome)) {
                throw new EmptyFieldException("O nome do turno não pode estar vazio");
            }
            return $this->turnoRepository->criarTurno($nome);
        } catch(Exception $e) {
            throw new UnexpectedErrorException("Ocorreu um erro inesperado ao cadastrar o turno");
        }
    }

    public function buscaTurnos(): array {
        try {
            $turnos = $this->turnoRepository->buscaTurnos();
            if(empty($turnos)) {
                throw new NotFoundException("Nenhum turno encontrado");
            }
            return $turnos;
        } catch(NotFoundException $e) {
            throw $e;
        } catch(Exception $e) {
            throw new UnexpectedErrorException("Ocorreu um erro inesperado ao buscar os turnos");
        }
    }
}