<?php

$page_container = get_field('page_container');

if($page_container) :
  $container_class = $page_container;
else :
  $container_class = 'max--width--smaller';
endif;

get_template_part('template-parts/generic/page-banner');

?>

<div class="<?php echo $container_class; ?>">
  <div class="entry-content">
    
    <?php the_content(); ?>

  </div>
</div>