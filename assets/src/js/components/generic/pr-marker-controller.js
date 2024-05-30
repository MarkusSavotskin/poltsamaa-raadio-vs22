class PrMarkerController {
  constructor() {
    this.initListener();
  }

  initListener() {
    window.addEventListener('load', () => this.highlightCurrentShow());
    setInterval(() => this.highlightCurrentShow(), 10000);
  }

  highlightCurrentShow() {
    const currentTime = new Date();
    const currentHour = currentTime.getHours();
    const currentMinute = currentTime.getMinutes();
    const currentTimeString = `${currentHour < 10 ? '0' + currentHour : currentHour}.${currentMinute < 10 ? '0' + currentMinute : currentMinute}`;

    const digits = document.querySelectorAll('.js-schedule-time-digit');

    digits.forEach(digit => {
      const digitTime = digit.innerHTML.trim();
      const [startHour, startMinute] = digitTime.split('.').map(Number);
      const nextDigit = digit.nextElementSibling;
      if (nextDigit) {
        const nextDigitTime = nextDigit.innerHTML.trim();
        const [endHour, endMinute] = nextDigitTime.split('.').map(Number);
        if (
          (currentHour > startHour || (currentHour === startHour && currentMinute >= startMinute)) &&
          (currentHour < endHour || (currentHour === endHour && currentMinute < endMinute))
        ) {

          digits.forEach(otherDigits => {
            otherDigits.classList.remove('marker--visible');
            otherDigits.classList.add('marker--hidden');
          });

          digit.classList.add('marker--visible');
          digit.classList.remove('marker--hidden');
        }
      } else {
        if (currentHour > startHour || (currentHour === startHour && currentMinute >= startMinute)) {

          digits.forEach(otherDigits => {
            otherDigits.classList.remove('marker--visible');
            otherDigits.classList.add('marker--hidden');
          });

          digit.classList.add('marker--visible');
          digit.classList.remove('marker--hidden');
        }
      }
    });
  }
}

const markerController = new PrMarkerController();
export default markerController;
