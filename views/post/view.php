<?php
/** @var yii\web\View $this  */

$this->title = 'Blog - My Posts';
?>
<h1 class="mb-4">My Posts</h1>


<?php if (count($posts)) : ?>

    <?php foreach ($posts as $post) : ?>
    <div class="container">
        <div class="row">

            <div class="col-sm-12 p-2">
                <div class="border border-dark rounded p-3">
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-8 col-md-7 col-lg-8 col-xl-9">
                                <h2 class="mb-3 h3 d-inline-block"><?=$post->topic ?></h2>
                            </div>
                            <div class="col">
                                <div class="w-100 d-md-inline-flex justify-content-end">
                                    <a href="/post/edit?id=<?=$post->id?>" class="btn btn-info d-block m-1">Edit post</a>
                                    <a href="/post/delete?id=<?=$post->id?>" class="btn btn-danger d-block m-1">Delete post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>Created date: <?=date('d.m.Y', strtotime($post->create_at)) ?></p>
                    <a href="/post/details?id=<?=$post->id?>" class="btn btn-secondary btn-sm d-block">Read More</a>
                </div>
            </div>

        </div>
    </div>


    <?php endforeach ?>

<?php else : ?>

<p class="h3 text-danger d-block"><i>You don't have any posts :(</i></p>
<a class="h3 text-secondary d-block" href="/post/create"><i>Create your first post :)</i></a>

<?php endif ?>



        

