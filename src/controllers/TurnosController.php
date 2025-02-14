<?php
require_once __DIR__ . "/../interfaces/services/ITurnoService.php";
require_once __DIR__ . "/../interfaces/repository/ITurnoRepository.php";
require_once __DIR__ . "/../services/TurnoService.php";
require_once __DIR__ . "/../repository/TurnoRepository.php";

class TurnosController {
    private ITurnoService $turnoService;

    public function __construct() {
        $this->turnoService = new TurnoService(new TurnoRepository());
    }

    public function cadastraTurnos() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $this->turnoService->criarTurno($data['nome']);
            echo json_encode(['message' => "Turno cadastrado com sucesso"]);
        } catch(Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function buscarTurnos() {
        try {
            $turnos = $this->turnoService->buscaTurnos();
            echo json_encode($turnos);
        } catch(Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}