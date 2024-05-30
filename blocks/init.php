<?php

// ACF Gutenberg blocks init for all the blocks

// Post data
$post_id = get_the_ID();

// Define anchor
$anchor = '';

if(!empty($block['anchor'])) {
  $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Enable custom classes useage
$class_name = $class;

if(!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}

// Generate unique block id
$unique_id  = substr(str_shuffle(md5(time())), 0, 10);

// Block width from ACF
$block_width = get_field('block_content_width');

// Block background from ACF
$block_background = get_field('block_background');

// Styles
$block_styles     = '';
$class_padding    = '';

$padding_desktop_array  = [];
$padding_mobile_array   = [];

// Block modify width
if(get_post_type($post_id) == 'teenus') {
  $block_width = 'max--width--full';

  if($block_background != 'block__transparent') {
    $block_cpt_class = 'block__singular-cpt--colored';
  } else {
    $block_cpt_class = 'block__singular-cpt';
  }
} else {
  $block_width = $block_width;
  $block_cpt_class = '';
}

// Block disable top and bottom paddings or set custom padding via ACF fields
$block_disable_top_padding    = get_field('disable_block_top_padding');
$block_disable_bottom_padding = get_field('disable_block_bottom_padding');
$block_custom_paddings        = get_field('block_custom_top_bottom_paddings');

if($block_disable_top_padding && $block_disable_bottom_padding && !$block_custom_paddings) {
  $class_padding .= ' paddding__y-both--null' . $block['noPadding'];
} elseif($block_disable_top_padding) {
  $class_padding .= ' padding__top--null' . $block['noTopPadding'];
} elseif($block_disable_bottom_padding) {
  $class_padding .= ' padding__bottom--null' . $block['noBottomPadding'];
}

if($block_custom_paddings) {
  $global_padding_top_desktop     = get_field('block_custom_top_padding_desktop');
  $global_padding_bottom_desktop  = get_field('block_custom_bottom_padding_desktop');
  $global_padding_top_mobile      = get_field('block_custom_top_padding_mobile');
  $global_padding_bottom_mobile   = get_field('block_custom_bottom_padding_mobile');

  $class_padding = ' block__padded';

  if($global_padding_top_desktop || $global_padding_bottom_desktop) {
    $padding_desktop_array = [
      '--p-top-desktop: ' . $global_padding_top_desktop . 'rem',
      '--p-bottom-desktop: ' . $global_padding_bottom_desktop . 'rem',
    ];
  }

  if($global_padding_top_mobile || $global_padding_bottom_mobile) {
    $padding_mobile_array = [
      '--p-top-mobile: ' . $global_padding_top_mobile . 'rem',
      '--p-bottom-mobile: ' . $global_padding_bottom_mobile . 'rem',
    ];
  }
}

$styles_array = array_merge($padding_desktop_array, $padding_mobile_array);

if(!empty($styles_array)) {
  $styles_imploded  = implode('; ', $styles_array);
  $block_styles     = 'style="' . $styles_imploded . '"';
}

$attr_class = 'block__wrapper' . $class_padding . ' ' . $class_name . ' ' . $block_width . ' ' . $block_background . ' ' . $block_cpt_class;

?>
