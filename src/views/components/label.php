<?php function Label($for,
    $texto,
    ?string $id = null,
    ?string $class = null) { ?>
    <link rel="stylesheet" href="../public/styles/output.css">
    <label
        <?= $id ? "id='{$id}'" : '' ?>
        class="text-zinc-600 <?= $class ?>"
        for="<?= $for ?>"><?= $texto ?></label>
<?php } ?>