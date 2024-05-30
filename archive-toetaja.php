<?php

// Define post values
$post_type   = 'toetaja';
$placeholder = get_template_directory_uri() . '/assets/dist/img/svg/placeholder-logo-small.svg';


get_header();
get_template_part('template-parts/generic/archive-banner');
?>

<section class="archive__section max--width--wider">
  <div class="archive__grid archive__grid--supporter">
    <?php
    $supporter_args = [
      'post_type'       => $post_type,
      'posts_per_page'  => -1,
      'post_parent'     => 0,
    ];

    $supporter_loop = new WP_Query($supporter_args);
    if ($supporter_loop->have_posts()) : ?>
      <div class="archive__grid archive__grid--supporter--company">
        <?php
        while ($supporter_loop->have_posts()) : $supporter_loop->the_post();
          $supporter_type = get_field('supporter_type');
          if ($supporter_type) :
            $supporter_company_logo = get_field('supporter_company_logo');
            $supporter_company_link = get_field('supporter_company_link');
            if ($supporter_company_logo) :
              if ($supporter_company_link) : ?>
                <a href="<?php echo esc_url($supporter_company_link); ?>" target="<?php echo $supporter_company_link ? '_blank' : ''; ?>">
                  <img class="js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo esc_url($supporter_company_logo); ?>" alt="<?php the_title(); ?>">
                </a>
              <?php else : ?>
                <div>
                  <img class="js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo esc_url($supporter_company_logo); ?>" alt="<?php the_title(); ?>">
                </div>
              <?php endif; ?>
        <?php endif;
          endif;
        endwhile;
        ?>
      </div>

      <div class="archive__grid archive__grid--supporter--person">
        <?php
        $supporter_loop->rewind_posts();
        while ($supporter_loop->have_posts()) : $supporter_loop->the_post();
          $supporter_type = get_field('supporter_type');
          if (!$supporter_type) :
            $full_name = get_the_title();
            $names     = explode(' ', $full_name);

            if (count($names) >= 2) {
              $first_name = $names[0];
              $last_name = implode(' ', array_slice($names, 1));

              echo '<h3>' . $first_name . '<br>' . $last_name . '</h3>';
            } else {
              echo '<h3>' . $full_name . '</h3>';
            }
          endif;
        endwhile;
        ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer();
