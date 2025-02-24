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
        <?php Card(class: "md:w-[25%] sm:w-[75%] h-[43%] mx-auto my-28", children: function() { ?>
            <?php CardHeader(texto: "Login")?>
            <?php CardContent(children: function() { ?>
                <form id="subscription-form" class="flex flex-col py-5 gap-2">
                    <?php Label(for: "usuario_login", texto: "Nome de Usuário:") ?>
                    <?php Input(id: "usuario_login", nome: "usuario_login", placeholder: "Nome de usuário", class: "h-9 border border-1 px-3 border-gray-300 rounded-md text-md") ?>

                    <?php Label(for: "usuario_senha", texto: "Senha:") ?>
                    <?php Input(id: "usuario_senha", tipo: "password", nome: "usuario_senha", placeholder: "Senha", class: "h-9 border border-1 px-3 border-gray-300 rounded-md") ?>

                    <div class="w-full flex justify-end">
                        <?php Button(texto: "Entrar", class: "rounded-md px-2 py-2 bg-green-600 text-white font-semibold hover:bg-green-700 cursor-pointer") ?>
                    </div>
                    
                    <?php CardFooter(texto: "Footer padrão") ?>
                </form>
            <?php }) ?>
        <?php }) ?>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const subscriptionForm = document.getElementById("subscription-form");

        subscriptionForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const login = document.getElementById("usuario_login");
            const senha = document.getElementById("usuario_senha");

            const cadastro = { usuario_login: login.value, usuario_senha: senha.value };

            fetch("http://localhost/teste%20php/api/login", {
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