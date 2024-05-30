<?php

// Define post values
$show_image  = get_the_post_thumbnail_url(get_the_ID(), 'large');
$placeholder = get_template_directory_uri() . '/assets/dist/img/svg/placeholder.svg';

?>

<a href="<?php echo get_the_permalink(); ?>" class="card__show">
  <div class="card__show--image-wrapper">
    <?php if ($show_image) : ?>
      <img class="card__show--image js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo $show_image; ?>" alt="<?php the_title(); ?>">
    <?php else : ?>
      <img class="card__show--image" src="<?php echo $placeholder; ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>
  </div>

  <h3 class="card__show--title"><?php the_title(); ?></h3>
</a>