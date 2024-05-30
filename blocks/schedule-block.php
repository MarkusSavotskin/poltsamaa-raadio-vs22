<?php

// ACF Gutenberg block template - Schedule block
// Define block class
$class = 'schedule';

// Include global gutenberg init
include locate_template('/blocks/init.php');

// Get schedules
$post_type = 'saatekava';

$schedule_posts = get_posts(array(
  'post_type' => $post_type
));

// Find schedule matching current date
if ($schedule_posts) {
  foreach ($schedule_posts as $schedule_post) {
    setup_postdata($schedule_post);

    if (date('d/m/Y') === get_field('schedule_date', $schedule_post->ID)) {

      $schedule_title = get_the_title($schedule_post->ID);
      $schedule_date  = get_field('schedule_date', $schedule_post->ID);
      $schedule_shows = get_field('schedule_shows', $schedule_post->ID);
    }
  }
  wp_reset_postdata();
}

if (isset($schedule_date) && isset($schedule_shows) && isset($schedule_title)) : ?>
  <section <?php echo $anchor; ?> class="<?php echo esc_attr($attr_class); ?>" <?php echo $block_styles; ?>>
    <div class="<?php echo $class; ?>__wrapper">
      <div class="<?php echo $class; ?>__left">
        <h2 class="<?php echo $class; ?>__left--title">
          <?php echo $schedule_title; ?>
        </h2>

        <h3 class="<?php echo $class; ?>__left--date">
          <?php echo str_replace('/', '.', $schedule_date); ?>
        </h3>
      </div>

      <div class="<?php echo $class; ?>__right">

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
          <div class="<?php echo $class; ?>__right--content">
            <div class="<?php echo $class; ?>__right--time">
              <div class="<?php echo $class; ?>__right--marker"></div>
              <div class="<?php echo $class; ?>__right--digit js-schedule-time-digit">
                <?php if (isset($schedule_show_start)) :
                  echo str_replace(':', '.', $schedule_show_start);
                endif; ?>
              </div>
            </div>

            <div class="<?php echo $class; ?>__right--separator">-</div>

            <div class="<?php echo $class; ?>__right--show">
              <div class="<?php echo $class; ?>__right--title">
                <?php if (isset($schedule_show_parent_title)) :
                  echo $schedule_show_parent_title;
                endif; ?>
              </div>

              <div class="<?php echo $class; ?>__right--description">
                <?php if (isset($schedule_show_description)) :
                  echo $schedule_show_description;
                endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>