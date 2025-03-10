<?php
/* Futuras modificações:
    - Reorganizar pasta "src"
    - Melhorar identificação de arquivos no autoload.php e router.php
    - Alterar create-project.php para refletir estas mudanças
*/
spl_autoload_register(function ($class) {
    $baseDir = realpath(__DIR__ . "/../");

    $classPath = str_replace(["App\\", "\\"], ["", DIRECTORY_SEPARATOR], $class);

    $dirPath = pathinfo($classPath, PATHINFO_DIRNAME);
    $dirPath = strtolower($dirPath);

    $fileName = pathinfo($classPath, PATHINFO_BASENAME);

    $file = $baseDir . DIRECTORY_SEPARATOR . $dirPath . DIRECTORY_SEPARATOR . $fileName . ".php";


    if (file_exists($file)) {
        require_once $file;
    } else {
        die(`Erro: Classe "$class" não encontrada. Caminho esperado: $file`);
    }
});
