
<div class="card">
    <?php the_post_thumbnail('post-thumbnail', ['class' => 'card-img-top'], ['alt' => '']) ?>
    <div class="card-body">
        <h4 class="card-title"><?php the_title() ?></h4>
        <div class="card-subtitle">
            <?php the_excerpt() ?>
        </div>
        <a href="<?php the_permalink() ?>" class="card-btn">Voir plus</a>
    </div>
</div>
