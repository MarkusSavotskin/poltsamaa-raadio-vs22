<?php

$remove_page_title        = get_field('remove_page_title');
$enable_custom_page_title = get_field('enable_custom_page_title');

if ($enable_custom_page_title) :
  $custom_page_title = get_field('custom_page_title');
endif;

if (!$remove_page_title) : ?>

  <div class="max--width--full">
    <div class="page__banner">
      <div class="max--width--wider">
        <div class="page__banner--title">
          <h1>
            <?php if ($enable_custom_page_title && $custom_page_title) : ?>
              <?php echo $custom_page_title; ?>
            <?php else : ?>
              <?php the_title(); ?>
            <?php endif; ?>
          </h1>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>