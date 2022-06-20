<?php
use yii\helpers\StringHelper;

/** @var yii\web\View $this  */

$this->title = 'Blog';
?>
<h1 class="mb-4">My Posts</h1>

<div class="container">
    <div class="row gx-5">

        <?php foreach ($posts as $post) : ?>

        <?php
        $description = StringHelper::truncateWords($post->description, 45);

        ?>

        <div class="col-sm-12 p-2">
            <div class="border border-dark rounded p-3">
                <h2 class="mb-3 h3 d-inline-block">
                    <?=$post->topic ?>
                    
                </h2>
                <a href="/post/delete?id=<?=$post->id?>" class="btn btn-danger float-right">Delete post</a>
                <a href="/post/edit?id=<?=$post->id?>" class="btn btn-info float-right mr-1">Edit post</a>
                <!-- <p><?=$description ?></p> -->
                <p>Created date: <?=date('d.m.Y', strtotime($post->create_at)) ?></p>
                <a href="#" class="btn btn-secondary btn-sm d-block">Read More</a>
            </div>
        </div>

        <?php endforeach ?>

    </div>
</div>
