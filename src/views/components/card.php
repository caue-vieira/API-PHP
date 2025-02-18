<?php function Card(
    ?string $class = null,
    ?string $id = null,
    ?callable $children = null,
) { ?>
    <div <?= $id ? "id='{$id}'": '' ?> class="border border-gray-300 rounded-2xl shadow-md shadow-gray-200 p-8 <?= $class ?>">
        <?php if($children) : ?>
            <?php $children() ?>
        <?php endif ?>
    </div>
<?php } ?>

<?php function CardHeader(?string $class = null, ?string $texto = null, ?callable $children = null) { ?>
    <div class="w-full <?= $class ?>">
        <h1 class="text-2xl font-semibold"><?= $texto ?></h1>
        <?php if($children) : ?>
            <?php $children() ?>
        <?php endif ?>
    </div>
<?php } ?>

<?php function CardContent(?string $class = null, ?callable $children = null) { ?>
    <div class="w-full <?= $class ?>">
        <?php if($children) : ?>
            <?php $children() ?>
        <?php endif ?>
    </div>
<?php } ?>

<?php function CardFooter(?string $class = null, ?callable $children = null, ?string $texto = null) { ?>
    <div class="w-full <?= $class ?>">
        <h1 class="font-semibold text-zinc-400 text-sm"><?= $texto ?></h1>
        <?php if($children) : ?>
            <?php $children() ?>
        <?php endif ?>
    </div>
<?php } ?>