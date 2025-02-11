<?php include __DIR__ . "/../components/button.php"; ?>
<?php include __DIR__ . "/../components/input.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/global.css">
    <title>Teste</title>
</head>
<body>
    <h1>Testando</h1>
    <div id="div-teste">
        <?php Input(null, false, null, "Digite algo"); ?>
        <div id="div-teste-botao">
            <?php Button("Salvar", "clica"); ?>
        </div>
    </div>
</body>
<script>
    function clica() {
        fetch("http://localhost/teste%20php/api/turnos")
            .then(response => response.json())
            .then(data => console.log(data))
    }
</script>
<style>
    #div-teste {
        display: flex;
        flex-direction: column;
    }
    #div-teste-botao {
        width: 100%;
        display: flex;
        justify-content: end;
    }
</style>
</html>