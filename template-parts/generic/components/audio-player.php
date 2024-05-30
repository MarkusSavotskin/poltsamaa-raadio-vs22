<?php

$episode_id     = get_the_ID();
$episode_source = get_field('episode_link', $episode_id);

?>

<?php if ($episode_source) : ?>
  <div class="audio-player" data-episode-id="<?php echo $episode_id; ?>" data-episode-source="<?php echo esc_url($episode_source); ?>">
    <div class="audio-player__progress">
      <div class="audio-player__time">
        <div class="audio-player__time--digits js-player-current-time">00:00:00</div>
        <div class="audio-player__time--digits js-player-end-time">00:00:00</div>
      </div>

      <div class="audio-player__bar-wrapper js-player-seek">
        <div class="audio-player__bar js-player-progress"></div>
      </div>
    </div>

    <div class="audio-player__controls">
      <div class="audio-player__volume">
        <img class="audio-player__volume-icon" src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/volume-blue.svg" alt="<?php _('Helitugevus'); ?>">

        <div class="audio-player__volume-slider"></div>
      </div>

      <img class="audio-player__rewind js-player-rewind" src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/rewind-10-blue.svg" alt="<?php _('Keri tagasi'); ?>">

      <div class="audio-player__state">
        <img class="audio-player__state--play js-player-play" src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/play-blue.svg" alt="<?php _('Esita'); ?>">
        <img class="audio-player__state--pause js-player-pause" src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/pause-blue.svg" alt="<?php _('Peata'); ?>">
      </div>

      <img class="audio-player__forward js-player-forward" src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/svg/forward-10-blue.svg" alt="<?php _('Keri edasi'); ?>">
    </div>
  </div>
<?php endif; ?>