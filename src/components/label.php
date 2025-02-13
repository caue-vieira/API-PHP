<?php function Label($for,
    $texto,
    ?string $id = null,
    ?string $css = null) { ?>
    <link rel="stylesheet" href="../public/styles/<?= $css ?>">
    <label id="<?= $id ?>" class="label-<?= $for ?>" for="<?= $for ?>"><?= $texto ?></label>
    <style>
        label {
            font-size: 15px;
            font-weight: 500;
        }
    </style>
<?php } ?>