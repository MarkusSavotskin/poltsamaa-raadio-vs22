<?php

// Definie post values
$episode_image     = get_the_post_thumbnail_url(get_the_ID(), 'large');
$episode_parent_id = $args['current_show_id'];
$placeholder       = get_template_directory_uri() . '/assets/dist/img/svg/placeholder.svg';

if (!$episode_image) {
  $episode_image = get_the_post_thumbnail_url($episode_parent_id);
}
?>

<div class="card__episode" episode-id="<?php echo get_the_ID(); ?>">
  <div class="card__episode--image-wrapper">
    <?php if ($episode_image) : ?>
      <img class="card__episode--image js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo $episode_image; ?>" alt="<?php the_title(); ?>">
    <?php else : ?>
      <img class="card__episode--image" src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/placeholder.svg" alt="<?php the_title(); ?>">
    <?php endif; ?>

    <div class="card__episode--overlay"></div>
  </div>

  <h4 class="card__episode--title"><?php the_title(); ?></h4>
</div>