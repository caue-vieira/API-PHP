<?php function Select(
    ?string $id = null,
    ?string $nome = null,
    ?string $default = null,
    ?string $class = null,
    ?callable $children = null
) { ?>
    <link rel="stylesheet" href="../public/styles/output.css">
    <select
    class="shadow px-1 <?= $class ?>"
    <?= $id ? "id='{$id}'" : '' ?>
    <?= $nome ? "name='{$nome}'" : '' ?>
    >
        <?php if($default) : ?>
            <option value="" disabled selected class="hidden"><?= $default ?></option>
        <?php endif ?>

        <?php if($children) : ?>
            <?php $children(); ?>
        <?php endif ?>
    </select>
<?php } ?>