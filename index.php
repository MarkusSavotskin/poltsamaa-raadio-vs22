<?php

get_header();

?>

<?php get_template_part('template-parts/generic/archive-banner'); ?>

<section class="archive__section archive__section--supporter max--width--wider">  <?php if (have_posts()) : ?>
    <div class="archive__grid archive__grid--posts">
      <?php while (have_posts()) :
        the_post();

        get_template_part('template-parts/generic/cards/card', 'post');

      endwhile; ?>

      <?php wp_reset_postdata(); ?>
    </div>

    <div class="archive__pagination">
      <?php echo paginate_links([
        'type'      => 'list',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => sprintf('<span class="sr-only">%s</span>', __('Eelmine leht', 'raadio')),
        'next_text' => sprintf('<span class="sr-only">%s</span>', __('Järgmine leht', 'raadio'))
      ]); ?>
    </div>
  <?php else : ?>
    <div>
      <?php esc_html_e('Postitusi ei leitud!', 'raadio'); ?>
    </div>
  <?php endif; ?>

</section>

<?php get_footer();
