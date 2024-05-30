<?php

// Define post values
$post_image   = get_the_post_thumbnail_url(get_the_ID(), 'large');
$placeholder  = get_template_directory_uri() . '/assets/dist/img/svg/placeholder-white.svg';

?>

<?php get_template_part('template-parts/generic/page-banner'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="max--width--medium article__section">
    <?php if ($post_image) : ?>
      <img class="article__image js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>">
    <?php else : ?>
      <img class="article__image article__image--placeholder" src="<?php echo $placeholder; ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>

    <p class="article__date">
      <?php _e('Lisatud: ', 'raadio') . the_date(); ?>
    </p>

    <div class="article__content entry-content">

      <?php the_content(); ?>

    </div>

    <?php get_template_part('template-parts/generic/components/back'); ?>

  </div>
</article>