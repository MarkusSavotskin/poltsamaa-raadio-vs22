<?php

$display_button = get_field('display_section_button');

if($display_button) :

  $button_style = get_field('section_button_style');
  $button_link  = get_field('section_button_link');

  if($button_link) :
    $link_url     = $button_link['url'];
    $link_title   = $button_link['title'];
    $link_target  = $button_link['target'] ? $button_link['target'] : '_self'; ?>

    <div class="block__button <?php echo $args; ?>">
      <a class="button <?php echo $button_style; ?>" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
    </div>
  <?php endif; ?>
<?php endif; ?>