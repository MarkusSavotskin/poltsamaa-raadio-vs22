import { addGlobalEventListener } from '../base/helpers.js';

class PrMobileMenuController {
  constructor() {
    this.initListeners();
  }

  initListeners() {
    addGlobalEventListener('click', '#js-main-menu-toggle', (e, currentTarget) =>
      PrMobileMenuController.toggleMenu(e, currentTarget)
    );

    addGlobalEventListener('click', '#js-main-menu li.menu-item a', e => {
      if (window.innerWidth < 1370 && e.target.getAttribute('href').includes('#')) {
        PrMobileMenuController.closeMenu();
      }
    });

    window.addEventListener('resize', e => {
      if (window.innerWidth > 1370) {
        PrMobileMenuController.closeMenu();
      }
    });
  }

  static toggleMenu(e, currentTarget) {
    const header  = document.querySelector('.site-header');
    const menu    = currentTarget.parentElement.parentElement.querySelector('.site-header__nav');
    const logo    = currentTarget.parentElement.parentElement.parentElement.querySelector('.site-header__logo');

    currentTarget.classList.toggle('active');
    menu.classList.toggle('active');
    
    if (header.classList.contains('sticky') || document.body.classList.contains('home')) {
      logo.classList.toggle('active');
    }

    if (menu.classList.contains('active')) {
      document.documentElement.classList.add('overflow--disable');
      header.classList.add('site-header--nav-open');
    } else {
      document.documentElement.classList.remove('overflow--disable');
      header.classList.remove('site-header--nav-open');
    }
  }

  static closeMenu() {
    const header    = document.querySelector('.site-header');
    const menu      = document.querySelector('.site-header__nav');
    const logo      = document.querySelector('.site-header__logo');
    const hamburger = document.getElementById('js-main-menu-toggle');

    menu.classList.remove('active');
    logo.classList.remove('active');
    hamburger.classList.remove('active');
    document.documentElement.classList.remove('overflow--disable');
    header.classList.remove('site-header--nav-open');
  }
}

window.PrMobileMenuController = new PrMobileMenuController();

export default PrMobileMenuController;
