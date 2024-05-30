<?php

// ACF Gutenberg block template - Hero block
// Define block class
$class = 'hero';

// Include global gutenberg init
include locate_template('/blocks/init.php');

// Load ACF values
$hero_title             = get_field('hero_title');
$hero_subtitle          = get_field('hero_subtitle');
$hero_text              = get_field('hero_text');
$hero_image             = get_field('hero_image');

$display_section_button = get_field('display_section_button');

if ($display_section_button) {
  $section_button_style = get_field('section_button_style');
  $section_button_link  = get_field('section_button_link');
}

if ($hero_image) : ?>
  <section <?php echo $anchor; ?> class="<?php echo esc_attr($attr_class); ?>" <?php echo $block_styles; ?>>
    <div class="<?php echo $class; ?>__wrapper">
      <img class="<?php echo $class; ?>__image js-image-lazyload" src="" data-src="<?php echo $hero_image; ?>" alt="">

      <div class="<?php echo $class; ?>__inner">
        <?php if ($hero_title || $hero_subtitle || $hero_text) : ?>
          <div class="<?php echo $class; ?>__content">
            <?php if ($hero_title) : ?>
              <h1 class="<?php echo $class; ?>__content--title">
                <?php echo $hero_title; ?>
              </h1>
            <?php endif; ?>

            <?php if ($hero_subtitle) : ?>
              <h2 class="<?php echo $class; ?>__content--subtitle">
                <?php echo $hero_subtitle; ?>
              </h2>
            <?php endif; ?>

            <?php if ($hero_text) : ?>
              <h3 class="<?php echo $class; ?>__content--text">
                <?php echo $hero_text; ?>
              </h3>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if ($display_section_button) :
          $link_url     = $section_button_link['url'];
          $link_title   = $section_button_link['title'];
          $link_target  = $section_button_link['target'] ? $section_button_link['target'] : '_self'; ?>

          <a class="button <?php echo $section_button_style; ?>" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>