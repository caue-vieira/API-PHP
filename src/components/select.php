<?php function Select(
    array $options = [],
    ?string $id = null,
    ?string $nome = null,
    ?string $default = null,
    ?string $css = null,
) { ?>
    <link rel="stylesheet" href="../public/styles/<?= $css ?>">
    <select 
    <?= $id ? "id='{$id}'" : '' ?>
    <?= $nome ? "name='{$nome}'" : '' ?>
    >
        <?php if($default) : ?>
            <option value="" disabled selected><?= $default ?></option>
        <?php endif ?>

        <?php foreach($options as $value => $label) : ?>
            <option value="<?= $value ?>"><?= $label ?></option>
        <?php endforeach ?>
    </select>
    <style>
        select {
            height: 40px;
            width: 250px;
            border-radius: 8px;
            border-color: #a9a9a9;
            border-width: 1px;
            padding: 4px;
        }
    </style>
<?php } ?>