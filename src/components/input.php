<?php function Input($id,
    ?string $nome = null,
    ?string $tipo = null,
    ?bool $readonly = false,
    ?string $value = null,
    ?string $placeholder = null,
    ?string $css = null) {
    $readonlyAttr = $readonly ? 'readonly' : ''
?>
    <link rel="stylesheet" href="../public/styles/<?= $css ?>">
    <input
        <?= $id ? "id='{$id}'" : '' ?>
        <?= $nome ? "name='{$nome}'" : '' ?>
        <?= $tipo ? "type='{$tipo}'" : '' ?>
        <?= $readonlyAttr ?>
        <?= $value ? "value='{$value}'" : '' ?>
        <?= $placeholder ? "placeholder='{$placeholder}'" : '' ?>>
    <style>
        input {
            height: 30px;
            width: 240px;
            border-radius: 8px;
            border-color: #a9a9a9;
            border-width: 1px;
            padding: 4px;
        }
        input::placeholder {
            font-weight: 600;
            font-size: 14px;
            color: #a9a9a9;
        }
    </style>
<?php } ?>