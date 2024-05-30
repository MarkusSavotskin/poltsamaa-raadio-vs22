<?php

$related_args = [
  'post_type'       => 'post',
  'posts_per_page'  => '3',
  'order'           => 'DESC',
  'post__not_in'    => array($post->ID),
];

$related_posts = new WP_Query($related_args);

if($related_posts->have_posts()) : ?>

  <div class="article__related">
    <h2 class="article__related--title"><?php _e('Huvitavat lugemist', 'psyhiaatriakeskus'); ?></h2>

    <div class="article__related--grid">
      <?php while($related_posts->have_posts()) :
        $related_posts->the_post();
        
        get_template_part('template-parts/generic/cards/card', 'post');

      endwhile; ?>
    </div>
  </div>

<?php endif; 
wp_reset_postdata(); ?>