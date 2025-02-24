<?php
namespace App\Middleware;

class AuthMiddleware {
    public static function auth($request) {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])) {
            $authHeader = $headers["Authorization"];

            if(strpos($authHeader, "Bearer") === 0) {
                $jwt = substr($authHeader, 7);

                $key = "chave_super_segura";

                $payload = JWT::verifyJWT($jwt, $key);

                if($payload) {
                    return $payload;
                } else {
                    http_response_code(401);
                    echo json_encode(["message" => "Token inválido"]);
                    exit();
                }
            }
        }
        http_response_code(400);
        echo json_encode(["message" => "Token não fornecido"]);
        exit();
    }
}