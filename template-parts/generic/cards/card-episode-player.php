<?php

// Definie post values
$episode_image     = get_the_post_thumbnail_url(get_the_ID(), 'large');
$episode_parent_id = $args['current_show_id'];
$placeholder       = get_template_directory_uri() . '/assets/dist/img/svg/placeholder.svg';

if (!$episode_image) {
  $episode_image = get_the_post_thumbnail_url($episode_parent_id);
}
?>

<div class="card__episode-player">
  <div class="card__episode-player--image-wrapper">
    <?php if ($episode_image) : ?>
      <img class="card__episode-player--image js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo $episode_image; ?>" alt="<?php the_title(); ?>">
    <?php else : ?>
      <img class="card__episode-player--image" src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/placeholder.svg" alt="<?php the_title(); ?>">
    <?php endif; ?>
  </div>

  <div class="card__episode-player--info">
    <h4 class="card__episode-player--show-title"><?php echo get_the_title($episode_parent_id); ?></h4>
    <h3 class="card__episode-player--episode-title"><?php the_title(); ?></h3>
  </div>

  <div class="card__episode-player--audio-player">
    <?php get_template_part('template-parts/generic/components/audio-player'); ?>
  </div>
</div>