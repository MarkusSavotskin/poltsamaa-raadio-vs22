<?php

$posts_banner     = get_field('posts_archive_banner', 'option');
$shows_banner     = get_field('shows_archive_banner', 'option');
$team_banner      = get_field('team_archive_banner', 'option');
$schedule_banner  = get_field('schedule_archive_banner', 'option');
$supporter_banner = get_field('supporter_archive_banner', 'option');

?>

<div class="max--width--full">
  <?php if (get_post_type(get_the_ID()) == 'saade' && $shows_banner) : ?>
    <?php if ($shows_banner) : ?>
      <div class="page__banner">
        <div class="page__banner--title">
          <div class="max--width--wider">
            <h1><?php echo $shows_banner; ?></h1>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php elseif (get_post_type(get_the_ID()) == 'toimetuse-liige' && $team_banner) : ?>

    <?php if ($team_banner) : ?>
      <div class="page__banner">
        <div class="page__banner--title">
          <div class="max--width--wider">
            <h1><?php echo $team_banner; ?></h1>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php elseif (get_post_type(get_the_ID()) == 'saatekava' && $schedule_banner) : ?>

    <?php if ($schedule_banner) : ?>
      <div class="page__banner">
        <div class="page__banner--title">
          <div class="max--width--wider">
            <h1><?php echo $schedule_banner; ?></h1>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php elseif (get_post_type(get_the_ID()) == 'toetaja' && $supporter_banner) : ?>

    <?php if ($supporter_banner) : ?>
      <div class="page__banner">
        <div class="page__banner--title">
          <div class="max--width--wider">
            <h1><?php echo $supporter_banner; ?></h1>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php elseif (get_post_type(get_the_ID()) == 'post' && $posts_banner) : ?>

    <?php if ($posts_banner) : ?>
      <div class="page__banner">
        <div class="page__banner--title">
          <div class="max--width--wider">
            <h1><?php echo $posts_banner; ?></h1>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>