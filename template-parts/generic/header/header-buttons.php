<?php

/**
 * Header element part.
 *
 * @package ws-simple-theme
 */

$header_buttons = get_field('header_buttons', 'option');

?>

<?php if($header_buttons) : ?>
  <div class="site-header__buttons">
    <div class="site-header__buttons--wrapper">
      <?php foreach($header_buttons as $button) : 
        $type = $button['header_button_type'];
        $text = $button['header_button_text'];
        $link = $button['header_button_link'];

        if($type == 'phone') : ?>
          <a href="tel:<?php echo $link; ?>" class="site-header__buttons--button"><?php echo $text; ?></a>
        <?php else: ?>
          <a href="<?php echo $link; ?>" class="site-header__buttons--button"><?php echo $text; ?></a>
        <?php endif; ?>
          
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>