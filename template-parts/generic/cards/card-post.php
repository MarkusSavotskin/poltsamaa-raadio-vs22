<?php

// Define post values
$post_image   = get_the_post_thumbnail_url(get_the_ID(), 'large');
$placeholder  = get_template_directory_uri() . '/assets/dist/img/svg/placeholder.svg';
$post_excerpt = get_the_excerpt();
$post_title   = get_the_title();

if (!empty($post_title)) {
  if (strlen($post_title) > 90) {
    $post_title = substr($post_title, 0, 90) . '...';
  }
}

if (!empty($post_excerpt)) {
  if (strlen($post_excerpt) > 120) {
    $post_excerpt = substr($post_excerpt, 0, 120) . '...';
  }
}

?>

<a class="card__post" href="<?php the_permalink(); ?>">
  <div class="card__post--image-wrapper">
    <?php if ($post_image) : ?>
      <img class="card__post--image js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>">
    <?php else : ?>
      <img class="card__post--image" src="<?php echo $placeholder; ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>
  </div>

  <div class="card__post--content">
    <h3 class="card__post--title"><?php echo $post_title; ?></h3>

    <?php if (!empty($post_excerpt)) : ?>
      <div class="card__post--excerpt">
        <?php echo $post_excerpt; ?>
      </div>
    <?php endif; ?>
  </div>
</a>