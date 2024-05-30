<?php
/**
 * The template for the front page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

get_header();?>

<div class="entry-content">
  <?php the_content(); ?>
</div>

<?php get_footer();
