import { Howl, Howler } from 'howler';

class PrAudioPlayerController {
  constructor() {
    this.initListener();
  }

  initListener() {
    document.addEventListener('DOMContentLoaded', () => this.initHowler());
  }

  initHowler() {
    const audioPlayer = document.querySelector('.audio-player');
    const playButton = audioPlayer.querySelector('.js-player-play');
    const pauseButton = audioPlayer.querySelector('.js-player-pause');
    const rewindButton = audioPlayer.querySelector('.js-player-rewind');
    const forwardButton = audioPlayer.querySelector('.js-player-forward');
    const progressBarContainer = audioPlayer.querySelector('.js-player-seek');
    const progressBar = audioPlayer.querySelector('.js-player-progress');
    const currentTimeDisplay = audioPlayer.querySelector('.js-player-current-time');
    const endTimeDisplay = audioPlayer.querySelector('.js-player-end-time');

    const episodeSource = audioPlayer.getAttribute('data-episode-source');

    const sound = new Howl({
      src: [episodeSource],
      html5: true,
      onload: () => {
        endTimeDisplay.textContent = this.formatTime(sound.duration());
      },
      onplay: () => {
        playButton.style.display = 'none';
        pauseButton.style.display = 'block';
        this.updateTimeDisplays();
      },
      onpause: () => {
        playButton.style.display = 'block';
        pauseButton.style.display = 'none';
      },
      onend: () => {
        playButton.style.display = 'block';
        pauseButton.style.display = 'none';
        this.updateTimeDisplays();
      },
      onseek: () => {
        this.updateTimeDisplays();
      }
    });

    playButton.addEventListener('click', () => {
      sound.play();
    });

    pauseButton.addEventListener('click', () => {
      sound.pause();
    });

    rewindButton.addEventListener('click', () => {
      const currentTime = sound.seek();
      const newTime = Math.max(currentTime - 10, 0);
      sound.seek(newTime);
      this.updateTimeDisplays();
    });

    forwardButton.addEventListener('click', () => {
      const currentTime = sound.seek();
      const newTime = Math.min(currentTime + 10, sound.duration());
      sound.seek(newTime);
      this.updateTimeDisplays();
    });

    progressBarContainer.addEventListener('click', (event) => {
      const { offsetX } = event;
      const seekPercentage = offsetX / progressBarContainer.clientWidth;
      const seekTime = seekPercentage * sound.duration();
      sound.seek(seekTime);
      this.updateTimeDisplays();
    });

    setInterval(() => {
      if (sound.playing()) {
        this.updateTimeDisplays();
      }
    }, 1000);

    this.updateTimeDisplays = () => {
      const currentTime = sound.seek();
      const duration = sound.duration();
      const currentTimeFormatted = this.formatTime(currentTime);
      const durationFormatted = this.formatTime(duration);
      
      progressBar.style.width = `${(currentTime / duration) * 100}%`;
      currentTimeDisplay.textContent = currentTimeFormatted;
      endTimeDisplay.textContent = durationFormatted;
    };

    this.formatTime = (seconds) => {
      const hours = Math.floor(seconds / 3600);
      const minutes = Math.floor((seconds % 3600) / 60);
      const remainingSeconds = Math.floor(seconds % 60);
      
      const formattedHours = hours.toString().padStart(2, '0');
      const formattedMinutes = minutes.toString().padStart(2, '0');
      const formattedSeconds = remainingSeconds.toString().padStart(2, '0');
      
      return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
    };
  }
}

new PrAudioPlayerController();
