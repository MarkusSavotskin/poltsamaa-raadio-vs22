<?php

// Define ACF values
$title          = get_the_title();
$schedule_date  = get_field('schedule_date', $post->ID);
$schedule_shows = get_field('schedule_shows', $post->ID);

?>

<div class="card__schedule">

  <div class="card__schedule--top">
    <h2 class="card__schedule--day"><?php echo $title; ?></h2>

    <h3 class="card__schedule--date">
      <?php echo str_replace('/', '.', $schedule_date); ?>
    </h3>
  </div>

  <div class="card__schedule--bottom">

    <?php foreach ($schedule_shows as $show) :
      $schedule_show               = $show['schedule_show'][0];
      $schedule_show_parent        = get_field('episode_parent', $schedule_show);

      if ($schedule_show_parent) {
        $schedule_show_parent        = $schedule_show_parent[0];
        $schedule_show_parent_title  = get_the_title($schedule_show_parent);
        $schedule_show_description   = get_field('episode_description', $schedule_show);
        $schedule_show_start         = $show['schedule_show_start'];
      }
    ?>
      <div class="card__schedule--row">
        <?php if (isset($schedule_show_start)) : ?>
          <div class="card__schedule--time">
            <?php echo str_replace(':', '.', $schedule_show_start); ?>
          </div>
        <?php endif; ?>

        <div class="card__schedule--show">
          <?php if (isset($schedule_show_parent_title)) : ?>
            <div class="card__schedule--title">
              <?php echo $schedule_show_parent_title; ?>
            </div>
          <?php endif; ?>

          <?php if (isset($schedule_show_description)) : ?>
            <div class="card__schedule--description">
              <?php echo $schedule_show_description; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>