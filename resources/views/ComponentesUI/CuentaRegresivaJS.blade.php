class Countdown {
  constructor(containerId, mensaje) {
    this.container = document.getElementById(containerId);
    this.display = document.createElement('div');
    this.container.appendChild(this.display);
    this.mensaje = mensaje;
  }

  init(seconds, onComplete = () => { }) {
    this.updateDisplay(seconds);

    const interval = setInterval(() => {
      seconds--;
      this.updateDisplay(seconds);

      if (seconds <= 0) {
        clearInterval(interval);
        onComplete();
      }
    }, 1000);
  }

  updateDisplay(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    const remainingSecondsString = remainingSeconds.toString().padStart(2, '0');
    this.display.textContent = this.mensaje + `${minutes}:${remainingSecondsString}`;
  }
}