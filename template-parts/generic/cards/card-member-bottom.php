<?php

// Define ACF values
$title          = get_the_title();
$member_type    = get_field('member_type', $post->ID);
$member_role    = get_field('member_role', $post->ID);
$member_contact = get_field('member_contact', $post->ID);
$member_image   = get_the_post_thumbnail_url($post, 'large');
$placeholder    = get_template_directory_uri() . '/assets/dist/img/svg/placeholder-logo-small.svg';

?>

<div class="card__member-bottom">
  <?php if ($member_image) : ?>
    <img class="card__member-bottom--image js-image-lazyload" src="<?php echo $placeholder; ?>" data-src="<?php echo $member_image; ?>" alt="<?php the_title(); ?>">
  <?php else : ?>
    <img class="card__member-bottom--image" src="<?php echo $placeholder; ?>" alt="<?php the_title(); ?>">
  <?php endif; ?>
  <div class="card__member-bottom--info">
    <?php if (!empty($title)) : ?>
      <h4 class="card__member-bottom--title"><?php echo esc_html($title); ?></h4>
    <?php endif; ?>
    <?php if (!empty($member_role)) : ?>
      <p class="card__member-bottom--role"><?php echo esc_html($member_role); ?></p>
    <?php endif; ?>
  </div>
</div>