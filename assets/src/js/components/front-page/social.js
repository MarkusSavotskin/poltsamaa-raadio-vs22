import { addGlobalEventListener } from '../base/helpers.js';
import feather from 'feather-icons'

class SocialIcons {
  constructor() {
    this.initListener();
  }

  initListener() {
    addGlobalEventListener('click', '#js-social-menu-toggle', (e, currentTarget) =>
    SocialIcons.toggleMenu(e, currentTarget)
    );

    window.addEventListener("load", () => {
      feather.replace();
    });
  }

  static toggleMenu(e, currentTarget) {
    const menu = document.querySelector('.social-icons');

    menu.classList.toggle('social-icons--active');
  }

  static closeMenu() {
    const menu = document.querySelector('.social-icons');

    menu.classList.remove('social-icons--active');
  }
}

window.SocialIcons = new SocialIcons();

export default SocialIcons;