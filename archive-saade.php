<?php

// Define post type
$post_type = 'saade';

get_header();
get_template_part('template-parts/generic/archive-banner');

?>

<section class="archive__section archive__section--shows max--width--wider">
  <div class="archive__grid archive__grid--shows">
    <?php
    $shows_args = [
      'post_type'       => $post_type,
      'posts_per_page'  => -1,
      'post_parent'     => 0,
    ];

    $shows_loop = new WP_Query($shows_args); ?>
    <?php if ($shows_loop->have_posts()) :
      while ($shows_loop->have_posts()) : $shows_loop->the_post();
        get_template_part('template-parts/generic/cards/card', 'show');
      endwhile;
    endif; ?>
  </div>
</section>

<?php get_footer();
