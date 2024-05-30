<?php

// Acf_Gutenberg_Blocks class

class Acf_Gutenberg_Blocks
{

  // Acf_Gutenberg_Blocks options page register constructor.

  public function __construct()
  {
    add_action('init', [$this, 'acf_init_gutenberg_category']);
    add_action('init', [$this, 'acf_init_block_types']);
    add_filter('allowed_block_types_all', [$this, 'allow_only_acf_blocks']);
  }

  // Register Gutenberg editor Põltsamaa Raadio theme category

  public function acf_init_gutenberg_category()
  {
    add_filter('block_categories_all', function ($categories) {
      $categories[] = [
        'title' => 'Põltsamaa Raadio',
        'slug'  => 'acf_theme_category'
      ];
      return $categories;
    });
  }

  // Register ACF Web Systems theme blocks.

  public function acf_init_block_types()
  {
    if (function_exists('acf_register_block_type')) {

      // Register ACF Gutenberg block - Simple content block
      acf_register_block_type(
        [
          'name'              => 'acf_simple_content',
          'title'             => __('Simple content block'),
          'render_template'   => 'blocks/simple-content-block.php',
          'category'          => 'acf_theme_category',
          'icon'              => 'menu-alt',
          'mode'              => 'edit',
        ]
      );
    }

    if (function_exists('acf_register_block_type')) {

      // Register ACF Gutenberg block - Hero block
      acf_register_block_type(
        [
          'name'              => 'acf_hero',
          'title'             => __('Hero block'),
          'render_template'   => 'blocks/hero-block.php',
          'category'          => 'acf_theme_category',
          'icon'              => 'align-full-width',
          'mode'              => 'edit',
        ]
      );
    }

    if (function_exists('acf_register_block_type')) {

      // Register ACF Gutenberg block - Schedule block
      acf_register_block_type(
        [
          'name'              => 'acf_schedule',
          'title'             => __('Schedule block'),
          'render_template'   => 'blocks/schedule-block.php',
          'category'          => 'acf_theme_category',
          'icon'              => 'schedule',
          'mode'              => 'edit',
        ]
      );
    }
  }

  // Allow only certain blocks to gutenberg editor

  public function allow_only_acf_blocks($allowed_blocks)
  {
    $registered_block_types = acf_get_block_types();
    $registered_blocks = [];

    foreach ($registered_block_types as $block_type) {
      $registered_blocks[] = $block_type['name'];
    }

    $default_blocks = [
      'core/paragraph',
      'core/heading',
      'core/list',
      'core/table',
      'core/code',
      'core/image',
    ];

    $allowed_blocks = array_merge($default_blocks, $registered_blocks);

    return $allowed_blocks;
  }
}
