<?php

/** @var yii\web\View $this */

$flash = Yii::$app->getSession()->getFlash($key);
?>

<div class="alert alert-<?= $key ?>">
    <?= $flash ?>
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
</div>