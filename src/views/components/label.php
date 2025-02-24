<?php function Label($for,
    $texto,
    ?string $id = null,
    ?string $class = null) {
    
    $defaultClass = "text-zinc-600";
    $classAttr = $class ? $defaultClass . '' . $class : $defaultClass;
?>
    <link rel="stylesheet" href="../public/styles/output.css">
    <label
        <?= $id ? "id='{$id}'" : '' ?>
        class="<?= $classAttr ?>"
        for="<?= $for ?>"><?= $texto ?></label>
<?php } ?>