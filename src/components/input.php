<?php function Input(?string $tipo = "text", ?bool $readonly = false, ?string $value) {
    $readonlyAttr = $readonly ? 'readonly' : ''    
?>
    <input type="<?= $tipo ?>" <?= $readonlyAttr ?> value="<?= $value ?>">
<?php } ?>