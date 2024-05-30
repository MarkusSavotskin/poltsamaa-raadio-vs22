<?php

// Load ACF values
$show_description = get_field('show_description');

// Define variables
$post_type         = 'osa';
$post_taxonomy     = 'hooaeg';
$current_show_id   = get_the_ID();

$episodes = get_posts(array(
  'post_type' => $post_type
));

// Get seasons
$seasons = get_terms([
  'taxonomy'   => $post_taxonomy,
  'hide_empty' => true,
  'parent'     => 0,
]);

?>


<?php get_template_part('template-parts/generic/page-banner'); ?>

<article id="show-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="max--width--wider show__section">


    <?php if ($show_description) : ?>
      <div class="show__description">
        <?php echo $show_description; ?>
      </div>
    <?php endif; ?>

    <div class="show__content">
      <div class="show__content--left">
        <?php
        // Display most recent episode
        $recent_episode_args = [
          'post_type'       => $post_type,
          'posts_per_page'  => 1,
          'post_parent'     => 0,
          'meta_query' => array(
            array(
              'key'     => 'episode_parent',
              'value'   => '"' . $current_show_id . '"',
              'compare' => 'LIKE',
            ),
          ),
        ];

        $episode_loop = new WP_Query($recent_episode_args);
        if ($episode_loop->have_posts()) :
          $args = array(
            'current_show_id' => $current_show_id,
          );

          while ($episode_loop->have_posts()) : $episode_loop->the_post();
            get_template_part('template-parts/generic/cards/card', 'episode-player', $args);
          endwhile;
        endif;
        ?>
      </div>

      <div class="show__content--right">
        <?php 
         // Display all episodes according to the season
        foreach ($seasons as $season) :
          $episodes_args = [
            'post_type'       => $post_type,
            'posts_per_page'  => -1,
            'post_parent'     => 0,
            'meta_query' => array(
              array(
                'key'     => 'episode_parent',
                'value'   => '"' . $current_show_id . '"',
                'compare' => 'LIKE',
              ),
            ),
            'tax_query'       => [
              [
                'taxonomy' => $post_taxonomy,
                'field'    => 'id',
                'terms'    => $season->term_id,
              ],
            ],
          ];

          $episodes_loop = new WP_Query($episodes_args); ?>
          <?php if ($episodes_loop->have_posts()) :
            $args = array(
              'current_show_id' => $current_show_id,
            ); ?>

            <h3 class="show__content--season"><?php echo esc_html($season->name); ?></h3>

            <div class="show__content--episodes">

              <?php
              while ($episodes_loop->have_posts()) : $episodes_loop->the_post();
                get_template_part('template-parts/generic/cards/card', 'episode', $args);
              endwhile;
              wp_reset_postdata(); ?>
            </div>
        <?php endif;
        endforeach; ?>
      </div>
    </div>

    <?php get_template_part('template-parts/generic/components/back'); ?>

  </div>
</article>