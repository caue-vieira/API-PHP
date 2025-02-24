<?php function Select(
    ?string $id = null,
    ?string $nome = null,
    ?string $default = null,
    ?string $class = null,
    ?callable $children = null
) {
    
    $defaultClass = "shadow border border-1 px-1 border-gray-300 rounded-md h-9";
    $classAttr = $class ? $defaultClass . '' . $class : $defaultClass;
?>
    <link rel="stylesheet" href="../public/styles/output.css">
    <select
    class="<?= $classAttr ?>"
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