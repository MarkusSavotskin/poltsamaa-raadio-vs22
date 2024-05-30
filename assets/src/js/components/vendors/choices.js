// https://github.com/Choices-js/Choices

import Choices from 'choices.js';

class ChoicesSelect {
  constructor() {
    this.singleSelectElements = document.querySelectorAll('.js-choices');
    this.initializeChoices();
    this.observeClassChanges();
  }

  initializeChoices() {
    this.initializeSingleSelect();
  }

  initializeSingleSelect() {
    if (this.singleSelectElements.length > 0) {
      this.singleSelectElements.forEach((singleElement) => {
  

        new Choices(singleElement, {
          allowHTML: true,
          searchEnabled: false,
          searchChoices: false,
        });
      });
    }
  }

  observeClassChanges() {
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.attributeName === 'class') {
          const targetElement = mutation.target;
          if (targetElement.classList.contains('wpcf7-not-valid')) {
            targetElement.parentElement.classList.add('not-valid')
          } else {
            targetElement.parentElement.classList.remove('not-valid')
          }
        }
      });
    });

    const config = { attributes: true };

    this.singleSelectElements.forEach((element) => {
      observer.observe(element, config);
    });
  }
}

new ChoicesSelect();