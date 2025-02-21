<?php
function createDirectories($baseDir, $projectName) {
    $dirs = [
        "$projectName/public/styles",
        "$projectName/src/config",
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
    ];

    foreach($dirs as $dir) {
        $dirPath = $baseDir . "/" . $dir;
        if(!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
            echo "Diretório criado: $dirPath\n";
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

                $controllerNamespace = "App\\\Controllers\\\$controllerName";

                $controllerInstance = new $controllerNamespace();
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

$router->addRoute("GET", "api/view/{viewName}", ["ViewController", "renderView"]);
$router->addRoute("GET", "api/usuarios/buscar", ["UsuariosController", "buscarUsuarios"]);
$router->addRoute("POST", "api/usuarios/cadastrar", ["UsuariosController", "cadastraUsuario"]);

$router->handleRequest();',
        "$projectName/.htaccess" => "RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.*)$ index.php?/$1 [QSA,L]",
    ];

    foreach($files as $file => $content) {
        $filePath = $baseDir . "/" . $file;
        if(!file_exists($filePath)) {
            file_put_contents($filePath, $content);
            echo "Arquivo criado: $filePath\n";
        } else {
            echo "Arquivo já existe: $filePath\n";
        }
    }
}

function createProject($baseDir, $projectName) {
    createDirectories($baseDir, $projectName);
    createFiles($baseDir, $projectName);
    echo "Projeto criado em $baseDir\n";
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