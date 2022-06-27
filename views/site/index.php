<?php
use yii\helpers\StringHelper;
use yii\bootstrap4\LinkPager;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Blog';
?>

<h1 class="mb-4">All Posts</h1>


<div class="container">

    <?php if ($sort == SORT_DESC) : ?>

        <a href="<?= Url::to(['site/index', 'sort' => SORT_ASC]) ?>">Sort from Oldest</a>

    <?php else : ?>

        <a href="<?= Url::to(['site/index', 'sort' => SORT_DESC]) ?>">Sort from Newest</a>

    <?php endif ?>

    <div class="row gx-5">

        <?php foreach ($posts as $post) : ?>

        <?php
        $description = StringHelper::truncateWords($post->description, 45, ' ...');

        ?>

        <div class="col-sm-12 col-md-6 col-lg-4 p-2">
            <div class="p-3">
                <h2 class="mb-0 h3"><?=$post->topic ?></h2>
                <p><small><i>Created: <?=date("d.m.Y H:i", strtotime($post->create_at)) ?></i></small></p>
                <p><?=$description ?></p>
                <a href="/post/details?id=<?=$post->id?>" class="btn btn-secondary btn-sm d-block">Read More</a>
            </div>
        </div>

        <?php endforeach ?>

    </div>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
