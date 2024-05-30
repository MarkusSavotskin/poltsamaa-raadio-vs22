<?php

// Define post type
$post_type = 'toimetuse-liige';

get_header();

get_template_part('template-parts/generic/archive-banner');

?>

<section class="archive__section archive__section--members max--width--wider">

  <div class="archive__grid archive__grid--members">


    <?php
    $members_args = [
      'post_type'       => $post_type,
      'posts_per_page'  => -1,
      'post_parent'     => 0,
    ];

    $members_loop = new WP_Query($members_args); ?>
    <div class="archive__grid archive__grid--members--top">
      <?php if ($members_loop->have_posts()) :
        while ($members_loop->have_posts()) : $members_loop->the_post();
          $members_type = get_field('member_type');
          if ($members_type) {
            get_template_part('template-parts/generic/cards/card', 'member-top');
          };
        endwhile;
      endif; ?>
    </div>

    <?php $members_loop->rewind_posts(); ?>
    <div class="archive__grid archive__grid--members--bottom">
      <?php if ($members_loop->have_posts()) :
        while ($members_loop->have_posts()) : $members_loop->the_post();
          $members_type = get_field('member_type');
          if (!$members_type) {
            get_template_part('template-parts/generic/cards/card', 'member-bottom');
          };
        endwhile;
      endif; ?>
    </div>

  </div>
</section>

<?php get_footer();
