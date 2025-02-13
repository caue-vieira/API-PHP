<?php function Button($texto,
    ?string $tipo = null,
    ?string $id = null,
    ?string $onclick = null,
    ?string $variante = null,
    ?string $css = null,) { ?>
    <link rel="stylesheet" href="../public/styles/<?= $css ?>">
    <button type="<?= $tipo ?>" id="<?= $id ?>" class="button<?= $variante ? "-{$variante}" : '' ?>" onclick="<?= $onclick ?>">
        <?= $texto ?>
    </button>
    <style>
        button {
            display: flex;
            align-items: center;
            padding: 8px;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            font-size: 16px;
            height: 40px;
        }
        .button {
            background-color: #0d0d0d;
            color: white;
        }
        .button:hover {
            cursor: pointer;
            background-color: #33363d;
        }

        .button-ghost {
            background-color: transparent;
            color: #0d0d0d;
        }
        .button-ghost:hover {
            cursor: pointer;
            background-color: lightgray;
        }
    </style>
<?php } ?>