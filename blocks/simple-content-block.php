<?php

// ACF Gutenberg block template - Simple content block
// Define block class
$class = 'simple-content';

// Include global gutenberg init
include locate_template('/blocks/init.php');

// Load ACF values
$simple_content = get_field('simple_content');

if($simple_content) : ?>
  <section <?php echo $anchor; ?> class="<?php echo esc_attr($attr_class); ?>" <?php echo $block_styles; ?>>
    <div class="<?php echo $class; ?>__wrapper">
      <?php echo $simple_content; ?>
    </div>
  </section>
<?php endif; ?>