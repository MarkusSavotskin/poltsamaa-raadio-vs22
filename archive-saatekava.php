<?php

// Define post type
$post_type = 'saatekava';

$posts = get_posts(array(
  'post_type' => $post_type
));

get_header();

get_template_part('template-parts/generic/archive-banner');

?>

<section class="archive__section archive__section--schedule max--width--wider">

  <div class="archive__grid archive__grid--schedule">

    <?php
    $schedule_args = [
      'post_type'       => $post_type,
      'posts_per_page'  => -1,
      'post_parent'     => 0,
    ];

    $schedule_loop = new WP_Query($schedule_args); ?>
    <?php if ($schedule_loop->have_posts()) :
      while ($schedule_loop->have_posts()) : $schedule_loop->the_post();

        get_template_part('template-parts/generic/cards/card', 'schedule');

      endwhile;
      wp_reset_postdata();
    endif; ?>
  </div>
</section>

<?php get_footer();
