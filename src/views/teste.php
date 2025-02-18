<?php require_once __DIR__ . "/components/button.php" ?>
<?php require_once __DIR__ . "/components/input.php" ?>
<?php require_once __DIR__ . "/components/label.php" ?>
<?php require_once __DIR__ . "/components/select.php" ?>
<?php require_once __DIR__ . "/components/card.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/output.css">
    <title>Teste</title>
</head>
<body class="antialiased">
        <?php
            $genders = [
                "M" => "Masculino",
                "F" => "Feminino",
                "N" => "Prefiro não dizer"
            ];
        ?>
        <?php Card(class: "md:w-[25%] sm:w-[75%] h-[43%] mx-auto my-28", children: function() use($genders) { ?>
            <?php CardHeader(texto: "Cadastre-se")?>
            <?php CardContent(children: function() use($genders) { ?>
                <form class="flex flex-col py-5 gap-2">
                    <?php Label(for: "nome_completo", texto: "Nome completo:") ?>
                    <?php Input(id: "nome_completo", nome: "nome_completo", placeholder: "Nome completo", class: "h-9 border border-1 px-3 border-gray-300 rounded-md text-md") ?>

                    <?php Label(for: "genero", texto: "Gênero:") ?>
                    <?php Select(id: "genero", default: "-Selecione-", nome: "genero", children: function() use($genders) { 
                        foreach($genders as $value => $gender) { ?>
                            <option value="<?= $value ?>"><?= $gender ?></option>
                    <?php }}, class: "rounded-md h-9 border border-gray-300 border-1") ?>

                    <?php Label(for: "email", texto: "Email:") ?>
                    <?php Input(id: "email", tipo: "email", nome: "email", placeholder: "Email", class: "h-9 border border-1 px-3 border-gray-300 rounded-md") ?>

                    <?php Label(for: "senha", texto: "Senha:") ?>
                    <?php Input(id: "senha", tipo: "password", nome: "senha", placeholder: "Senha", class: "h-9 border border-1 px-3 border-gray-300 rounded-md") ?>

                    <?php Button(tipo: "button", texto: "Cadastre-se", onclick: "enviaFormulario()", class: "rounded-md px-2 py-2 bg-green-600 text-white font-semibold hover:bg-green-700 cursor-pointer mx-auto") ?>
                    <?php CardFooter(children: function() { ?>
                        <h2 class="text-sm text-center text-zinc-600">Já tem uma conta? <a onclick="clica()" class="cursor-pointer underline hover:text-zinc-400">Faça login</a></h2>
                    <?php }) ?>
                    <?php CardFooter(texto: "Ou faça login com:", class: "text-center") ?>
                    <div class="space-y-2">
                        <?php Button(tipo: "button", texto: "Github", class: "w-full h-9 rounded-md font-semibold border border-zinc-300 hover:bg-zinc-200 cursor-pointer") ?>
                        <?php Button(tipo: "button", texto: "Google", class: "w-full h-9 rounded-md font-semibold border border-zinc-300 hover:bg-zinc-200 cursor-pointer") ?>
                    </div>
                    <?php CardFooter(texto: "Obtenha gnose") ?>
                </form>
            <?php }) ?>
        <?php }) ?>
</body>
<script>
    function clica() {
        fetch("http://localhost/teste%20php/api/usuarios/buscar")
            .then(response => response.json())
            .then(data => console.log(data))
        const input = document.getElementById("input");
    }

    function enviaFormulario() {
        const nome = document.getElementById("nome_completo");
        const genero = document.getElementById("genero");
        const email = document.getElementById("email");
        const senha = document.getElementById("senha");

        const cadastro = {
            nome: nome.value,
            genero: genero.value,
            email: email.value,
            senha: senha.value,
        };

        fetch("http://localhost/teste%20php/api/usuarios/cadastrar", {
            headers: {
                "Content-Type": "application/json",
            },
            method: "POST",
            body: JSON.stringify(cadastro)
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
            })
    }
</script>
</html>