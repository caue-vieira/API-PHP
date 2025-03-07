<?php
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

$runner->run();