<?php

/**
 * Header top bar element part.
 *
 * @package ws-simple-theme
 */

$company_email    = get_field('company_email', 'option');
$company_phone    = get_field('company_phone', 'option');
$company_location = get_field('company_location', 'option');

?>

<?php if($company_email || $company_phone || $company_location) : ?>
  <ul class="site-header__contacts">
    <li><?php _e('Võta meiega ühendust', 'psyhiaatriakeskus'); ?></li>
    <?php if($company_phone) : ?>
      <li>
        <i data-feather="phone"></i>
        <a href="tel:<?php echo $company_phone; ?>" target="_blank" rel="noopener"><?php echo $company_phone; ?></a>
      </li>
    <?php endif; ?>

    <?php if($company_email) : ?>
      <li>
        <i data-feather="home"></i>
        <a href="mailto:<?php echo $company_email; ?>" target="_blank" rel="noopener"><?php echo $company_email; ?></a>
      </li>
    <?php endif; ?>

    <?php if($company_location) : ?>
      <li>
        <i data-feather="map-pin"></i>
        <?php echo $company_location; ?>
      </li>
    <?php endif; ?>
  </ul>
<?php endif; ?>