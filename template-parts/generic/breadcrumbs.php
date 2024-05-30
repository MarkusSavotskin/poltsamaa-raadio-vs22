<?php

$remove_breadcrumbs = get_field('remove_page_breadcrumbs');
$page_container     = get_field('page_container');

if(!$remove_breadcrumbs) :

  if($page_container) :
    if($page_container == 'max--width--full') {
      $container_class = 'max--width--smaller';
    } else {
      $container_class = $page_container;
    }
  else :
    $container_class = 'max--width--smaller';
  endif;

  ?>

  <div class="<?php echo $container_class; ?>">
    <div class="breadcrumbs">
      <?php if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb();
      } ?>
    </div>
  </div>
<?php endif; ?>