<?php

$post_id    = get_the_ID();
$ancestors  = get_post_ancestors($post_id);

?>

<div class="page__back">
  <?php if(!empty($ancestors)) {
    $parent_post_id         = $ancestors[0];
    $parent_post_permalink  = get_permalink($parent_post_id); ?>
    <a class="button button--primary-filled button--outlined-primary button--condensed button--back" href="<?php echo esc_url($parent_post_permalink); ?>"><?php _e('Tagasi', 'raadio'); ?></a>
  <?php } else {
    $post_type              = get_post_type($post_id);
    $post_type_archive_link = get_post_type_archive_link($post_type); ?>

    <a class="button button--primary-filled button--outlined-primary button--condensed button--back" href="<?php echo esc_url($post_type_archive_link); ?>"><?php _e('Tagasi', 'raadio'); ?></a>
  <?php } ?>
</div>