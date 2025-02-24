<?php function Input($id,
    ?string $nome = null,
    ?string $tipo = null,
    ?bool $readonly = false,
    ?string $value = null,
    ?string $placeholder = null,
    ?string $class = null) {
    $readonlyAttr = $readonly ? 'readonly' : '';

    $defaultClass = "h-9 border border-1 px-3 border-gray-300 rounded-md text-md";
    $classAttr = $class ? $defaultClass . '' . $class : $defaultClass;
?>
    <link rel="stylesheet" href="../public/styles/output.css">
    <input
        class="shadow <?= $classAttr ?>"
        <?= $id ? "id='{$id}'" : '' ?>
        <?= $nome ? "name='{$nome}'" : '' ?>
        <?= $tipo ? "type='{$tipo}'" : '' ?>
        <?= $readonlyAttr ?>
        <?= $value ? "value='{$value}'" : '' ?>
        <?= $placeholder ? "placeholder='{$placeholder}'" : '' ?>/>
<?php } ?>