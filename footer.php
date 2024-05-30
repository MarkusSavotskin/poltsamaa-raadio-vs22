<?php

/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

$footer_logo         = get_field('site_light_logo', 'option');
$footer_sections     = get_field('footer_sections', 'option');
$company_name        = get_field('company_name', 'option');
$company_location    = get_field('company_location', 'option');
$social_media_icons  = get_field('social_media_icons', 'option');

?>

</main>

</div><!-- #page -->

<footer id="colophon" class="site-footer">

  <div class="max--width--wider">
    <div class="site-footer__wrapper">
      <div class="site-footer__top">
        <div class="site-footer__columns">
          <?php foreach ($footer_sections as $section) : ?>
            <div class="site-footer__column">
              <?php if ($section['footer_section_type'] === 'logo') : ?>
                <a href="<?php echo esc_url(home_url()); ?>" rel="home" title="<?php bloginfo('name'); ?>">
                  <img class="site-footer__column--logo" src="<?php echo $footer_logo; ?>" alt="<?php bloginfo('name'); ?>">
                </a>
              <?php endif; ?>

              <?php if ($section['footer_section_type'] === 'image') : ?>
                <img class="site-footer__column--image" src="<?php echo $section['footer_section_image']; ?>" alt="">
              <?php endif; ?>

              <?php if ($section['footer_section_type'] === 'info') : ?>
                <?php if ($section['footer_section_title']) : ?>
                  <h3 class="site-footer__column__info--title"><?php echo $section['footer_section_title']; ?></h3>
                <?php endif; ?>

                <?php if ($section['footer_section_fields']) : ?>
                  <?php foreach ($section['footer_section_fields'] as $field) : ?>
                    <?php if ($field['footer_field_type'] === 'link') : ?>
                      <a href="<?php echo esc_url($field['footer_field_link']['url']); ?>" class="site-footer__column__info--row"><?php echo $field['footer_field_link']['title']; ?></a>
                    <?php endif; ?>

                    <?php if ($field['footer_field_type'] === 'phone') : ?>
                      <a href="tel:<?php echo $field['footer_field_text']; ?>" class="site-footer__column__info--row"><?php echo $field['footer_field_text']; ?></a>
                    <?php endif; ?>

                    <?php if ($field['footer_field_type'] === 'email') : ?>
                      <a href="mailto:<?php echo $field['footer_field_text']; ?>" class="site-footer__column__info--row"><?php echo $field['footer_field_text']; ?></a>
                    <?php endif; ?>

                    <?php if ($field['footer_field_type'] === 'text') : ?>
                      <p class="site-footer__column__info--row"><?php echo $field['footer_field_text']; ?></p>
                    <?php endif; ?>

                  <?php endforeach; ?>
                <?php endif; ?>
              <?php
              endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="site-footer__bottom">
        <?php if ($company_name || $company_location || $footer_privacy_policy_link) : ?>
          <ul class="site-footer__fields">
            <?php if ($company_name) : ?>
              <li>
                <p><?php echo '© ' . date('Y') . ' ' . $company_name; ?></p>
              </li>
            <?php endif; ?>

            <?php if ($company_location) : ?>
              <li>
                <p><?php echo $company_location; ?></p>
              </li>
            <?php endif; ?>

            <?php if (get_privacy_policy_url()) : ?>
              <li>
                <a href="<?php echo esc_url(get_privacy_policy_url()); ?>"><?php _e('Privaatsuspoliitika', 'raadio'); ?></a>
              </li>
            <?php endif; ?>
          </ul>
        <?php endif; ?>

        <ul class="site-footer__socials">
          <?php if ($social_media_icons) : ?>
            <?php foreach ($social_media_icons as $social) :
              $social_media_link = $social['social_media_link'];
              $social_media_icon = $social['social_media_icon']; ?>

              <li class="site-footer__social">
                <a href="<?php echo $social_media_link; ?>" target="_blank">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/<?php echo $social_media_icon; ?>-logo.svg" alt="">
                </a>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
          <!--
          <li class="developer__websystems">
            <a href="https://www.websystems.ee/" target="_blank" rel="noopener" title="Web Systems OÜ">
              <img src="https://websystems.ee/ws-logos/ws-small-white-logo.svg" alt="Websystems Logo" />
            </a>
          </li>
          -->
        </ul>
      </div>

    </div>
  </div>

</footer><!-- #colophon -->

<?php get_template_part('template-parts/generic/ie-alert'); ?>

<div id="js-page-shadow"></div>

<?php wp_footer(); ?>

</body>

</html>