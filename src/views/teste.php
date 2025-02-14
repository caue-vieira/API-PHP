<?php include __DIR__ . "/../components/button.php"; ?>
<?php include __DIR__ . "/../components/input.php"; ?>
<?php include __DIR__ . "/../components/label.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/global.css">
    <title>Teste</title>
</head>
<body>
    <h1>Testando</h1>
    <div id="div-teste">
        <form onsubmit="enviaFormulario()">
            <?php Label(for: "input", id: "label-input", texto: "Teste label", css: "teste-label.css") ?>
            <?php Input(id: "input", placeholder: "Digite algo", css: "teste-input.css"); ?>

            <?php Label(for: "input-2", texto: "Teste label 2") ?>
            <?php Input(id: "input-2", placeholder: "Digite algo", css: "teste-input.css", readonly: true); ?>

            <?php Button(texto: "Enviar") ?>
        </form>

        <div id="div-teste-botao">
            <?php Button(texto: "Salvar", tipo: "button"); ?>
            <?php Button(texto: "Salvar 2", id: "botao-2", onclick: "clica()", css: "teste-button.css", tipo: "button"); ?>
            <?php Button(texto: "Salvar 3", id: "salvar-3", onclick: "clica()", variante: "ghost", tipo: "button"); ?>
        </div>
    </div>
</body>
<script>
    function clica() {
        fetch("http://localhost/teste%20php/api/turnos/buscar")
            .then(response => response.json())
            .then(data => console.log(data))
        const input = document.getElementById("input");
    }

    function enviaFormulario() {
        const input = document.getElementById("input");
        const input2 = document.getElementById("input-2");

        const formulario = {
            input_1: input.value,
            input_2: input2.value,
        };
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