<?php function Button($texto,
    ?string $tipo = null,
    ?string $id = null,
    ?string $onclick = null,
    ?string $class = null,) {
    
    $defaultClass = "rounded-md px-2 py-2 bg-green-600 text-white font-semibold hover:bg-green-700 cursor-pointer";
    $classAttr = $class ? $defaultClass . '' . $class : $defaultClass;
?>
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