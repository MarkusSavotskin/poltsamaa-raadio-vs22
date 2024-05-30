import Splide from '@splidejs/splide';
import '@splidejs/splide/css/core';

class WsSlidersController {
  constructor() {
    this.initListeners();
  }

  initListeners() {
    window.addEventListener('load', () => {
      WsSlidersController.initializeSlider();
    });
  }

  static initializeSlider() {
    const initiatorClass = '.gallery';
    const sliderClass = initiatorClass + '.splide';
    const sliders = document.querySelectorAll(sliderClass);

    if (sliders.length) {
      for (var i = 0; i < sliders.length; i++) {
        var slide = sliders[i];

        const sliderOptions = {
          type: 'fade',
          lazyLoad: 'nearby',
          focus: 0,
          speed: 2000,
          interval: 6000,
          autoplay: true,
          drag: false,
          arrows: false,
          pauseOnHover: false,
          height: "100vh",
          cover: true,
          rewind: true
        };

        const slider = new Splide(slide, sliderOptions);
        slider.mount();
      }
    }
  }
}

window.WsSlidersController = new WsSlidersController();

/*import Swiper from 'swiper';
import { Autoplay, EffectFade } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/autoplay';

class GalleryFade {
  constructor() {
    this.initListener();
  }

  initListener() {
    window.addEventListener('load', () =>
      GalleryFade.swiperSlider()
    );
  }

  static swiperSlider() {
    const swiper = new Swiper('.swiper', {
      modules: [Autoplay, EffectFade],
      speed: 2000,
      effect: 'fade',
      fadeEffect: {
        crossFade: false,
      },
      autoplay: {
        delay: 10000,
        disableOnInteraction: false,
      },
      loop: true,

    });
  }
}

window.GalleryFade = new GalleryFade();

export default GalleryFade;*/