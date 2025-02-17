<?php
require_once __DIR__ . "/../interfaces/services/ITurnoService.php";
require_once __DIR__ . "/../interfaces/repository/ITurnoRepository.php";
require_once __DIR__ . "/../services/TurnoService.php";
require_once __DIR__ . "/../repository/TurnoRepository.php";
require_once __DIR__ . "/../errors/emptyFieldException.php";
require_once __DIR__ . "/../errors/notFoundException.php";
require_once __DIR__ . "/../errors/unexpectedErrorException.php";

class TurnosController {
    private ITurnoService $turnoService;

    public function __construct() {
        $this->turnoService = new TurnoService(new TurnoRepository());
    }

    public function cadastraTurnos() {
        header("Content-Type: application/json");

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $this->turnoService->criarTurno($data['nome']);
            echo json_encode(['message' => "Turno cadastrado com sucesso"]);
        } catch(EmptyFieldException | UnexpectedErrorException $e) {
            http_response_code($e->getCode());
            echo json_encode(['message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno do servidor']);
        }
    }

    public function buscarTurnos() {
        header("Content-Type: application/json");

        try {
            $turnos = $this->turnoService->buscaTurnos();
            echo json_encode($turnos);
        } catch(NotFoundException | UnexpectedErrorException $e) {
            http_response_code($e->getCode());
            echo json_encode(['message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno do servidor']);
        }
    }
}