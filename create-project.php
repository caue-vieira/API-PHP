<?php
function createDirectories($baseDir, $projectName) {
    $dirs = [
        "$projectName/tests",
        "$projectName/tests/config",
        "$projectName/tests/mocks",
        "$projectName/public/styles",
        "$projectName/src/config",
        "$projectName/src/config/http",
        "$projectName/src/controllers",
        "$projectName/src/database",
        "$projectName/src/errors",
        "$projectName/src/interfaces",
        "$projectName/src/interfaces/services",
        "$projectName/src/interfaces/repository",
        "$projectName/src/middleware",
        "$projectName/src/models",
        "$projectName/src/repository",
        "$projectName/src/services",
        "$projectName/src/validators",
        "$projectName/src/views",
        "$projectName/src/views/components",
        "$projectName/src/views/styles",
    ];

    foreach($dirs as $dir) {
        $dirPath = $baseDir . "/" . $dir;
        if(!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
            echo "[INFO] Diretório criado: $dirPath\n";
        } else {
            echo "Diretório já existe: $dirPath\n";
        }
    }
}

function createFiles($baseDir, $projectName) {
    $files = [
        "$projectName/src/config/autoload.php" => '<?php
spl_autoload_register(function ($class) {
    $baseDir = realpath(__DIR__ . "/../");

    $classPath = str_replace(["App\\\", "\\\"], ["", DIRECTORY_SEPARATOR], $class);

    $dirPath = pathinfo($classPath, PATHINFO_DIRNAME);
    $dirPath = strtolower($dirPath);

    $fileName = pathinfo($classPath, PATHINFO_BASENAME);

    $file = $baseDir . DIRECTORY_SEPARATOR . $dirPath . DIRECTORY_SEPARATOR . $fileName . ".php";


    if (file_exists($file)) {
        require_once $file;
    } else {
        die(`Erro: Classe "$class" não encontrada. Caminho esperado: $file`);
    }
});',
        "$projectName/src/config/router.php" => '<?php

use App\Http\Request;
class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            "method" => strtoupper($method),
            "path" => $path,
            "handler" => $handler,
        ];
    }

    public function handleRequest() {
        $requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $requestUri = str_replace(["/teste php", "/teste%20php"], "", $requestUri);
        $requestUri = trim($requestUri, "/");

        foreach($this->routes as $route) {
            $pattern = preg_replace("/{([^}]+)}/", "([^/]+)", $route["path"]);
            if($route["method"] === $requestMethod && preg_match("#^$pattern$#", $requestUri, $matches)) {
                array_shift($matches);

                $controllerName = $route["handler"][0];
                $methodName = $route["handler"][1];

                require_once __DIR__ . "/../controllers/" . $controllerName . ".php";

                $controllerNamespace = "App\\Controllers\\$controllerName";

                $controllerInstance = new $controllerNamespace();

                try {
                    if($requestMethod !== "GET") {
                        $request = new Request();
                        array_unshift($matches, $request);
                    }
                    
                    call_user_func_array([$controllerInstance, $methodName], $matches);
                } catch(NoBodyException $e) {
                    http_response_code($e->getCode());
                    echo json_encode(["message" => $e->getMessage()]);
                }
                return;
                
                call_user_func_array([$controllerInstance, $methodName], $matches);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada"]);
    }
}',
        "$projectName/src/config/uuid.php" => '<?php
namespace App\Config;

class UUID {
    public static function generateUuidV4(): string {
        return sprintf("%04x%04x-%04x-%04x-%04x-%04x%04x%04x",
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}',
        "$projectName/index.php" => '<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

require_once "src/config/autoload.php";
require_once "src/config/router.php";

$router = new Router();

$router->addRoute("GET", "views/{viewName}", ["ViewController", "renderView"]);

$router->handleRequest();',
        "$projectName/.htaccess" => "RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.*)$ index.php?/$1 [QSA,L]",
        "$projectName/src/middleware/middleware.php" => '<?php
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
}',
        "$projectName/src/middleware/jwt.php" => '<?php
namespace App\Middleware;

class JWT {
    public static function generateJWT($payload, $key) {
        $header = json_encode(["alg" => "HS256", "typ" => "JWT"]);

        $headerB64 = base64_encode($header);
        $payloadB64 = base64_encode($payload);

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
}',
        "$projectName/src/database/database.php" => '<?php
namespace App\Database;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): ?PDO {
        if(self::$connection === null) {
            try {
                $host = "localhost";
                $dbname = "";
                $username = "postgres";
                $password = "";
                $port = "5432";

                self::$connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Lança exceções em caso de erro
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Retorna dados em formato de array associativo
                    PDO::ATTR_EMULATE_PREPARES => false //Usa prepared statements
                ]);
            } catch(PDOException $e) {
                die("Ocorreu um erro ao conectar com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}',
        "$projectName/src/controllers/ViewController.php" => '<?php
namespace App\Controllers;

class ViewController {
    public static function renderView() {
        header("Content-Type: text/html");
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $parts = explode("/", trim($uri, "/"));
        $viewName = end($parts);

        $viewPath = __DIR__ . "/../views/" . $viewName . ".php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            http_response_code(404);
            echo "View não encontrada";
        }
    }
}',
        "$projectName/src/config/http/request.php" => '<?php
namespace App\Http;

use App\Errors\NoBodyException;

class Request {
    private array $data;

    public function __construct() {
        $json = file_get_contents("php://input");
        if(!$json) {
            throw new NoBodyException("Não foi possível processar a requisição", 400);
        }
        $this->data = json_decode($json, true);
    }

    public function input(string $key, $default = null) {
        return $this->data[$key] ?? $default;
    }

    public function all(): array {
        return $this->data;
    }
}',
        "$projectName/src/errors/noBodyException.php" => '<?php
namespace App\Errors;

use Exception;
use Throwable;

class NoBodyException extends Exception {
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}',
        "$projectName/src/views/view.php" => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, World</title>
</head>
<body>
    <div style="display: flex; width: 100%; text-align: center">
        <h1>Olá, mundo!</h1>
        <p>Você criou este projeto utilizando o comando create-project.php</p>
    </div>
</body>
</html>',
        "$projectName/tests/config/test_runner.php" => '<?php
namespace Tests;

use Exception;

require_once __DIR__ . "/../../src/config/autoload.php";

class TestRunner {
    private array $tests = [];

    public function addTest(callable $testFunction, string $name) {
        $this->tests[] = ["name" => $name, "function" => $testFunction];
    }

    public function run() {
        foreach($this->tests as $test) {
            try {
                call_user_func($test["function"]);
                echo "[✔] PASSED: {$test["name"]}\n";
            } catch(Exception $e) {
                echo "[✖] FAILED: {$test["name"]} - " . $e->getMessage() . "\n";
            }
        }
    }
}

$runner = new TestRunner();

function assertEquals($expected, $recieved, $message = "") {
    if($expected !== $recieved) {
        throw new Exception(
            $message . "\n - Esperado: " . json_encode($expected) . "\n - Recebido: " . json_encode($recieved)
        );
    }
}

$files = array_merge(
    glob(__DIR__ . "/../mocks/*Mock.php"),
    glob(__DIR__ . "/../*_test.php"),
);

foreach($files as $file) {
    if(!strpos($file, "/config/")) {
        require_once $file;
    }
}

$runner->run();'
    ];

    foreach($files as $file => $content) {
        $filePath = $baseDir . "/" . $file;
        if(!file_exists($filePath)) {
            file_put_contents($filePath, $content);
            echo "[INFO] Arquivo criado: $filePath\n";
        } else {
            echo "Arquivo já existe: $filePath\n";
        }
    }
}

function createProject($baseDir, $projectName) {
    createDirectories($baseDir, $projectName);
    echo "\n";
    createFiles($baseDir, $projectName);

    echo "\nDeseja utilizar TailwindCSS para estilização? (S/N) ";
    $input = trim(fgets(STDIN));

    if(strtolower($input) === "s") {
        echo "\n\033[1;32mIniciando configurações TailwindCSS...\033[0m\n";
        installTailwind($baseDir, $projectName);
    }
    
    echo "\033[1;32mProjeto criado em $baseDir/$projectName\033[0m";
}

function installTailwind($baseDir, $projectName) {
    $packageJson = [
        "dependencies" => [
            "@tailwindcss/cli" => "^4.0.6",
            "tailwindcss" => "^4.0.6"
        ]
    ];

    $packageJsonPath = $baseDir . "/$projectName/package.json";
    file_put_contents($packageJsonPath, json_encode($packageJson));
    file_put_contents("$baseDir/$projectName/.gitignore", '/node_modules',);

    echo "[INFO] Arquivo package.json criado\n";

    echo "\033[1;32mInstalando TailwindCSS...\033[0m\n";

    $output = shell_exec("cd {$baseDir}/$projectName && npm install");

    if ($output === null) {
        echo "\033[1;31m[ERRO] Falha ao executar o comando. Verifique se o npm está instalado corretamente\033[0m\n";
        echo "\033[1;34m[ERRO] Iniciando projeto sem dependências...\033[0m\n";
        cleanFilesIfError([$packageJsonPath]);
        return;
    }

    $cssDir = $baseDir . "/$projectName/src/views/styles";
    if(!is_dir($cssDir)) {
        mkdir($cssDir, 0777, true);
    }

    $inputCssPath = $cssDir . "/input.css";
    file_put_contents($inputCssPath, '@import "tailwindcss";');

    echo "[INFO] Arquivo input.css criado em {$inputCssPath}\n";

    $command = "cd {$baseDir}/$projectName && npx tailwindcss -i ./src/views/styles/input.css -o ./public/styles/output.css";
    exec($command, $output, $exitCode);

    if ($exitCode !== 0) {
        echo "\033[1;31m[ERRO] Falha ao executar o TailwindCSS\033[0m\n";
        echo "\033[1;34m[ERRO] Iniciando projeto sem dependências...\033[0m\n";
        $outputCssPath = $baseDir . "/$projectName/public/styles/output.css";
        $packageLockPath = $baseDir . "/$projectName/package-lock.json";
        cleanFilesIfError([$packageJsonPath, $inputCssPath, $outputCssPath, $packageLockPath]);
        return;
    }

    echo "\n\033[1;32mTailwindCSS instalado com sucesso\033[0m\n\n";
    $linha = str_repeat("═", 90); // Linha horizontal para destacar a mensagem

    echo "\n\033[1;32m$linha\033[0m\n"; // Linha verde
    echo "\033[1;36mIMPORTANTE: Para que o TailwindCSS aplique atualizações automaticamente, execute:\033[0m\n";
    echo "\033[1;34m=> npx tailwindcss -i ./src/views/styles/input.css -o ./public/styles/output.css --watch\033[0m\n";
    echo "\n\033[1;36mOu, sempre que fizer alterações no CSS, execute:\033[0m\n";
    echo "\033[1;34m=> npx tailwindcss -i ./src/views/styles/input.css -o ./public/styles/output.css\033[0m\n";
    echo "\033[1;32m$linha\033[0m\n\n";

    if(file_exists($baseDir . "/$projectName/src/views/view.php")) {
        unlink($baseDir . "/$projectName/src/views/view.php");
        file_put_contents($baseDir . "/$projectName/src/views/view.php", '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/output.css">
    <title>Hello, World</title>
</head>
<body>
    <div class="w-full text-center">
        <h1 class="text-2xl font-semibold">Olá, mundo!</h1>
        <p>Você criou este projeto utilizando o comando create-project.php</p>
    </div>
</body>
</html>');
    }
}

function cleanFilesIfError($files) {
    foreach($files as $file) {
        if(file_exists($file)) {
            unlink($file);
            echo "\033[1;33m[INFO] Arquivo removido: {$file}\033[0m\n";
        }
    }
}

function cleanDirsIfError($dirs) {
    foreach($dirs as $dir) {
        if(is_dir($dir) && count(scandir($dir)) == 2) {
            rmdir($dir);
            echo "\033[1;33m[INFO] Diretório removido: {$dir}\033[0m\n";
        }
    }
}

if($argc < 2) {
    echo "Uso: php create-project.php <diretório-do-projeto>\n";
}

$baseDir = $argv[1];
$projectName = $argv[2];

if(!is_dir($baseDir)) {
    echo "Criando diretório base: $baseDir\n";
    mkdir($baseDir, 0755, true);
}

createProject($baseDir, $projectName);