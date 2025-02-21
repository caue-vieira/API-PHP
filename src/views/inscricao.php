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
            $trilhas = [
                "1" => "C#",
                "2" => "Java",
                "3" => "React",
                "4" => "Node",
                "5" => "Python",
                "6" => "HTML + CSS",
            ];
        ?>
        <?php Card(class: "md:w-[25%] sm:w-[75%] h-[43%] mx-auto my-28", children: function() use($trilhas) { ?>
            <?php CardHeader(texto: "Inscreva-se")?>
            <?php CardContent(children: function() use($trilhas) { ?>
                <form id="subscription-form" class="flex flex-col py-5 gap-2">
                    <?php Label(for: "nome_completo", texto: "Nome completo:") ?>
                    <?php Input(id: "nome_completo", nome: "nome_completo", placeholder: "Nome completo", class: "h-9 border border-1 px-3 border-gray-300 rounded-md text-md") ?>

                    <?php Label(for: "email", texto: "Email:") ?>
                    <?php Input(id: "email", tipo: "text", nome: "email", placeholder: "Email", class: "h-9 border border-1 px-3 border-gray-300 rounded-md") ?>

                    <?php Label(for: "trilha", texto: "Trilha:") ?>
                    <?php Select(id: "trilha", default: "Nenhuma trilha selecionada", nome: "trilha", children: function() use($trilhas) { 
                        foreach($trilhas as $value => $trilha) { ?>
                            <option value="<?= $value ?>"><?= $trilha ?></option>
                    <?php }}, class: "rounded-md h-9 border border-gray-300 border-1") ?>

                    <div class="w-full flex justify-end">
                        <?php Button(texto: "Inscreva-se", class: "rounded-md px-2 py-2 bg-green-600 text-white font-semibold hover:bg-green-700 cursor-pointer") ?>
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

    document.addEventListener("DOMContentLoaded", function () {
        const subscriptionForm = document.getElementById("subscription-form");

        subscriptionForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const nome = document.getElementById("nome_completo");
            const trilha = document.getElementById("trilha");
            const email = document.getElementById("email");

            const cadastro = { nome: nome.value, trilha: trilha.value, email: email.value };

            fetch("http://localhost/teste%20php/api/usuarios/cadastrar", {
                headers: { "Content-Type": "application/json" },
                method: "POST",
                body: JSON.stringify(cadastro),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                })
                .catch((error) => {
                    console.error("Erro ao enviar requisição:", error);
                });
        });
    });
</script>
</html>