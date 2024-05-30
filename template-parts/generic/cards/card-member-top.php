<?php

// Define ACF values
$title          = get_the_title();
$member_type    = get_field('member_type', $post->ID);
$member_role    = get_field('member_role', $post->ID);
$member_contact = get_field('member_contact', $post->ID);
$member_image   = get_the_post_thumbnail_url($post, 'large');
$placeholder    = get_template_directory_uri() . '/assets/dist/img/svg/placeholder-logo-big.svg';

?>

<div class="card__member-top">
  <div class="card__member-top--portrait">
    <?php if ($member_image) : ?>
      <img class="card__member-top--image js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo $member_image; ?>" alt="<?php the_title(); ?>">
    <?php else : ?>
      <img class="card__member-top--image" src="<?php echo $placeholder; ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>
  </div>

  <div class="card__member-top--info">
    <?php if (!empty($title)) : ?>
      <h3 class="card__member-top--title"><?php echo esc_html($title); ?></h3>
    <?php endif; ?>
    <?php if (!empty($member_role)) : ?>
      <p class="card__member-top--role"><?php echo esc_html($member_role); ?></p>
    <?php endif; ?>
    <?php if (!empty($member_contact)) : ?>
      <a href="tel:<?php echo esc_url($member_contact); ?>" class="card__member-top--contact"><?php echo esc_html($member_contact); ?></a>
    <?php endif; ?>
  </div>
</div>