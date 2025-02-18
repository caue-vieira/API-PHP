<?php function Input($id,
    ?string $nome = null,
    ?string $tipo = null,
    ?bool $readonly = false,
    ?string $value = null,
    ?string $placeholder = null,
    ?string $class = null) {
    $readonlyAttr = $readonly ? 'readonly' : ''
?>
    <link rel="stylesheet" href="../public/styles/output.css">
    <input
        class="shadow <?= $class ?>"
        <?= $id ? "id='{$id}'" : '' ?>
        <?= $nome ? "name='{$nome}'" : '' ?>
        <?= $tipo ? "type='{$tipo}'" : '' ?>
        <?= $readonlyAttr ?>
        <?= $value ? "value='{$value}'" : '' ?>
        <?= $placeholder ? "placeholder='{$placeholder}'" : '' ?>/>
<?php } ?>