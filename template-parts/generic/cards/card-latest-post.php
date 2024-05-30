<?php

$post_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
$excerpt    = get_the_excerpt();

if(!empty($excerpt)) :
  $excerpt    = substr($excerpt, 0, 200) . '...';
endif;

?>

<div class="card card__post-latest <?php echo ($post_image) ? 'card__post-latest--imaged' : ''; ?>" style="<?php echo ($post_image) ? 'background-image: url(' . $post_image . ');' : ''; ?>">
  <div class="max--width--smaller">
    <div class="card__post-latest--content">
      <h1><?php the_title(); ?></h1>

      <?php if(!empty($excerpt)) : ?>
        <div class="card__post-latest--excerpt">
          <?php echo $excerpt; ?>
        </div>
      <?php endif; ?>

      <a class="button button--outlined-white button--pill" href="<?php the_permalink(); ?>"><?php _e('Loe edasi', 'psyhiaatriakeskus'); ?></a>
    </div>
  </div>
</div>