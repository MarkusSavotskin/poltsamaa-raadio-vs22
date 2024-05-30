class PrStickyHeaderController {
  constructor(header) {
    this.header = header;
    this.headerHeight = this.header.scrollHeight;
    this.sticky = header.offsetTop;

    window.addEventListener('scroll', () => {
      this.stickyHeader();
    });

    this.addStaticClass();
    this.stickyHeader();
  }

  addStaticClass() {
    this.header.classList.add('site-header--loaded');
  }

  stickyHeader() {
    if (window.scrollY > 0) {
      this.header.classList.add('site-header--sticky');
    } else {
      this.header.classList.remove('site-header--sticky');
      this.header.classList.remove('site-header--loaded');
    }
  }
}

document.querySelectorAll('header').forEach(el => {
  new PrStickyHeaderController(el);
});