<?php
class TurnosController {
    public function filtrarTurnos() {
        // $json = file_get_contents("php://input");
        // $data = json_decode($json, true);

        // if(!isset($data['data'])) {
        //     http_response_code(400);
        //     echo json_encode(['error' => 'Parâmetro "data" é obrigatório']);
        //     return;
        // }

        $turnos = [
            ["id" => 1, "nome" => "Turno A"],
            ["id" => 2, "nome" => "Turno B"],    
        ];

        echo json_encode($turnos);
    }

    public function buscarTurnos() {
        $turnos = [
            ["id" => 3, "nome" => "Turno C"],
            ["id" => 4, "nome" => "Turno D"],    
        ];

        echo json_encode($turnos);
    }

    public function cadastraTurno() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if(!isset($data['nome'])) {
            http_response_code(400);
            echo json_encode(['error' => "O campo 'nome' é obrigatório"]);
            return;
        }

        $novoTurno = [
            "id" => rand(3, 100),
            "nome" => $data['nome'],
        ];

        echo json_encode(['message' => "Turno cadastrado com sucesso!", "turno" => $novoTurno]);
    }
}