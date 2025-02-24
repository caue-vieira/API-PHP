<?php
namespace App\Middleware;

class JWT {
    public static function generateJWT($payload, $key) {
        $header = json_encode(["alg" => "HS256", "typ" => "JWT"]);

        $headerB64 = base64_encode($header);
        $payloadB64 = base64_encode(json_encode($payload));

        $signature = hash_hmac("sha256", "$headerB64.$payloadB64", $key, true);
        $signatureB64 = base64_encode($signature);

        $token = "$headerB64.$payloadB64.$signatureB64";

        return $token;
    }

    public static function verifyJWT($jwt, $key) {
        list($headerB64, $payloadB64, $signatureB64) = explode(".", $jwt);

        $signature = base64_decode($signatureB64);

        $headerAndPayload = "$headerB64.$payloadB64";

        $expectedSignature = hash_hmac("sha256", $headerAndPayload, $key, true);

        if($signature !== $expectedSignature) {
            return false;
        }

        $payloadJson = base64_decode($payloadB64);
        $payload = json_decode($payloadJson, true);

        return $payload;
    }
}