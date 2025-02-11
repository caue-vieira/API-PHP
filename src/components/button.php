<?php function Button($texto, $onclick, ?string $variante = null) { ?>
    <button id="button<?= $variante ? "-{$variante}" : '' ?>" onclick="<?= $onclick ?>()">
        <?= $texto ?>
    </button>
    <style>
        button {
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            font-size: 16px;
        }
        #button {
            background-color: #0d0d0d;
            color: white;
        }
        #button:hover {
            cursor: pointer;
            background-color: #33363d;
        }

        #button-ghost {
            background-color: transparent;
            color: #0d0d0d;
        }
        #button-ghost:hover {
            cursor: pointer;
            background-color: lightgray;
        }
    </style>
<?php } ?>