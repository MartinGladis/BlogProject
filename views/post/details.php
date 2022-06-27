<?php
/** @var  yii\web\View $this */

$this->title = $post->topic;
$createDate = date('d.m.Y H:i', strtotime($post->create_at))
?>

<div class="user-details">
    <?php if(!Yii::$app->user->isGuest) : ?>
        <div class="d-flex justify-content-end">
            <a href="/post/edit?id=<?=$post->id?>" class="btn btn-info m-1">Edit post</a>
            <a href="/post/delete?id=<?=$post->id?>" class="btn btn-danger m-1 delete-post-button">Delete post</a>
        </div>
    <?php endif ?>

    <h1 class="mt-3"><?=$post->topic ?></h1>
    <h3 class="h6 font-weight-light mb-4 font-italic"><small>Created: <?=$createDate ?></small></h3>


    <div><?=$post->description ?></div>

    <div class="container mt-5">
        
        <?php foreach ($post->files as $key => $file) : ?>
            <?php $base64 = base64_encode($file->blob); ?>

            <div class="row border-bottom border-dark">

                <div class="col-8 col-md-9 my-2 d-flex justify-content-center align-items-center">
                    <?php if (str_starts_with($file->mime_type, 'image/')) : ?>
                        
                        
                        <a class="w-75 mx-auto" href="/file/view?id=<?=$file->id ?>" target="_blank">
                            <img class="w-100" src='<?="data:$file->mime_type;base64,$base64"?>' alt="<?=$file->filename  ?>">
                        </a>
                    <?php else : ?>
                        <a class="text-dark" href="/file/view?id=<?=$file->id ?>" target="_blank"><?=$file->filename ?></a>
                    <?php endif ?>
                </div>
                <div class="col d-flex justify-content-center align-items-center my-2">
                    <a href="/file/download?id=<?=$file->id ?>" class="btn btn-secondary">Download</a>
                </div>
            </div>

        <?php endforeach ?>

    </div>
</div>
