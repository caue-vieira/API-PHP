<?php function Button($texto,
    ?string $tipo = null,
    ?string $id = null,
    ?string $onclick = null,
    ?string $class = null,) { ?>
    <link rel="stylesheet" href="../public/styles/output.css">
    <button 
        <?= $tipo ? "type='$tipo'" : '' ?> 
        <?= $id ? "id='$id'" : '' ?> 
        class="shadow px-3 <?= $class ?>" 
        <?= $onclick ? "onclick='$onclick'" : '' ?>
    >
        <?= $texto ?>
    </button>
<?php } ?>