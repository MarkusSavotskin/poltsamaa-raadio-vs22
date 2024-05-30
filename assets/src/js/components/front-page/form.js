import { addGlobalEventListener } from '../base/helpers.js';

class FormControl {
  constructor() {
    this.initListener();
  }

  initListener() {
    addGlobalEventListener('click', '.wpcf7-submit', () =>
      FormControl.hideForm()
    );
  }

  static hideForm() {
    const form = document.querySelector('.form__form-fields');
    const formDesc = document.querySelector('.form__desc');

    const errorTip = document.querySelector('.wpcf7-not-valid-tip');
    const wpcf7Response = document.querySelector('.wpcf7-response-output');

    if (!errorTip) {

      form.classList.toggle('form__form-fields--hidden');
      formDesc.innerHTML = 'Täname! Info edastatud.';
    }

    if(wpcf7Response) {
      wpcf7Response.remove();
    }

  }
}

window.FormControl = new FormControl();

export default FormControl;