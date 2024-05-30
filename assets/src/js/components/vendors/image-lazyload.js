// https://github.com/verlok/vanilla-lazyload

class ImageLazyload {
  constructor() {
    this.initListener();
  }

  initListener() {
    window.addEventListener('load', () => this.lazyloadImages());
  }

  lazyloadImages() {
    const images = document.querySelectorAll('.js-image-lazyload');
    const imageOptions = {};

    const imageObserver = new IntersectionObserver((entries, imageObserver) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const image = entry.target;

        if (image.getAttribute('data-src')) {
          const newImage = new Image();

          newImage.onload = () => {
            image.src = image.getAttribute('data-src');
            image.classList.add('js-image-lazyload--fade');
            imageObserver.unobserve(entry.target);
          };

          newImage.src = image.getAttribute('data-src');
        }
      });
    }, imageOptions);

    images.forEach((image) => {
      imageObserver.observe(image);
    });
  }
}

new ImageLazyload();