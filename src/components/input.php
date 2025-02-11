<?php function Input(?string $tipo = "text", ?bool $readonly = false, ?string $value, ?string $placeholder) {
    $readonlyAttr = $readonly ? 'readonly' : ''    
?>
    <input id="input" type="<?= $tipo ?>" <?= $readonlyAttr ?> value="<?= $value ?>" placeholder="<?= $placeholder ?>">
    <style>
        input {
            height: 30px;
            width: 240px;
            border-radius: 8px;
            border-color: gray;
            border-width: 1px;
            padding: 4px;
        }
        input::placeholder {
            font-weight: bold;
        }
    </style>
<?php } ?>