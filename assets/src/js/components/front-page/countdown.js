class CountdownInitializer {
  constructor() {
    this.initListener();
  }

  initListener() {
    window.addEventListener('load', () =>
      CountdownInitializer.countdown()
    );
  }

  static countdown() {
    // Find the correct element
    const element = document.getElementById("js-countdown-timer")

    // Set the date we're counting down to from element attribute
    var countdownDate = new Date(element.getAttribute("countdown-date")).getTime();

    // Update the count down every 1 second
    var x = setInterval(() => {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countdownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the results
      document.getElementById("digit-days").innerHTML = days;
      document.getElementById("digit-hours").innerHTML = hours;
      document.getElementById("digit-minutes").innerHTML = minutes;
      document.getElementById("digit-seconds").innerHTML = seconds;

      // Output text in plural or singular
      if (days === 1) {
        document.getElementById("text-days").innerHTML = "päev";
      } else {
        document.getElementById("text-days").innerHTML = "päeva";
      }

      if (hours === 1) {
        document.getElementById("text-hours").innerHTML = "tund";
      } else {
        document.getElementById("text-hours").innerHTML = "tundi";
      }


      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
      }
    }, 1000);
  }
}

window.CountdownInitializer = new CountdownInitializer();

export default CountdownInitializer;