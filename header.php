<?php

/**
 * The header for our theme
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

$logo_light              = get_field('site_light_logo', 'option');
$logo_dark               = get_field('site_logo', 'option');
$enable_header_button    = get_field('enable_header_button', 'option');

if ($enable_header_button) {
  $header_button_text = get_field('header_button_text', 'option');
  $header_button_link = get_field('header_button_link', 'option');
}

?>

<!doctype html>

<html class="mode-switch" <?php language_attributes(); ?>>

<head>
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() . '/assets/dist/img/apple-touch-icon.png'; ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() . '/assets/dist/img/favicon-32x32.png'; ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() . '/assets/dist/img/favicon-16x16.png'; ?>">
  <link rel="manifest" href="<?php echo get_template_directory_uri() . '/site.webmanifest'; ?>">
  <link rel="mask-icon" href="<?php echo get_template_directory_uri() . '/assets/dist/img/safari-pinned-tab.svg'; ?>" color="#005b4a">

  <meta name="msapplication-TileColor" content="#005b4a">
  <meta name="theme-color" content="#005b4a">

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="profile" href="http://gmpg.org/xfn/11">

  <?php if (class_exists('ACF')) {
    echo get_field('header_scripts', 'option');
  } ?>

  <?php wp_head(); ?>

</head>

<style>
  :root {
    --color-brand-primary: <?php echo get_field('brand_primary_color', 'option'); ?>;
    --color-brand-secondary: <?php echo get_field('brand_secondary_color', 'option'); ?>;
    --color-brand-accent: <?php echo get_field('brand_accent_color', 'option'); ?>;
    --color-brand-text: <?php echo get_field('brand_text_color', 'option'); ?>;
    --color-brand-first-gradient: <?php echo get_field('brand_first_gradient', 'option'); ?>;
    --color-brand-second-gradient: <?php echo get_field('brand_second_gradient', 'option'); ?>;
  }
</style>

<body <?php body_class(); ?> id="js-page-body">

  <?php if (class_exists('ACF')) {
    echo get_field('body_scripts', 'option');
  } ?>

  <div class="cursor outer"></div>
  <div class="cursor inner"></div>

  <div id="page" class="site">
    <header id="js-masthead" class="site-header <?php if (is_front_page()) {echo 'site-header--home';} ?>">
      <div class="site-header__container max--width--full">

        <div class="site-header__logo">
          <a href="<?php echo get_home_url(); ?>" class="site-header__logo--link" rel="home" title="<?php echo get_bloginfo('name'); ?>">
            <?php if ($logo_light) : ?>
              <img class="site-header__logo--light" src="<?php echo esc_url($logo_light); ?>" alt="<?php echo get_bloginfo('name'); ?>">
            <?php endif; ?>

            <?php if ($logo_dark) : ?>
              <img class="site-header__logo--dark" src="<?php echo esc_url($logo_dark); ?>" alt="<?php echo get_bloginfo('name'); ?>">
            <?php endif; ?>
          </a>
        </div>

        <div class="site-header__inner">
          <div class="site-header__nav">
            <nav class="site-header__menu" id="js-main-menu-container" navigation-list>
              <?php if (has_nav_menu('header_menu')) {
                wp_nav_menu([
                  'theme_location' => 'header_menu',
                  'menu_class'     => 'site-header__main-menu',
                  'menu_id'        => 'js-main-menu',
                ]);
              } ?>
            </nav>

          </div>

          <div class="site-header__hamburger">
            <button id="js-main-menu-toggle" class="site-header__hamburger__button <?php if (is_front_page()) {echo 'site-header__hamburger__button--home';} ?> header--breakpoint">
              <span class="site-header__hamburger--line"></span>
              <span class="site-header__hamburger--line"></span>
              <span class="site-header__hamburger--line"></span>
              <span class="site-header__hamburger--close"></span>
            </button>
          </div>
        </div>

        <?php if ($enable_header_button) : ?>
          <div class="site-header__button">
            <a href="<?php echo $header_button_link; ?>" class="button button--secondary-filled button--condensed"><?php echo $header_button_text; ?></a>
          </div>
        <?php endif; ?>
      </div>
    </header><!-- #masthead -->

    <main id="js-main" class="site-content <?php if(!is_front_page()) { echo 'site-content--default'; } ?>">