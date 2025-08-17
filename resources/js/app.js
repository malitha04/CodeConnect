import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

let __alpineStarted = false;
const startAlpine = () => {
  if (!__alpineStarted) {
    Alpine.start();
    __alpineStarted = true;
  }
};

document.addEventListener('DOMContentLoaded', startAlpine);
document.addEventListener('turbo:load', () => {
  __alpineStarted = false;
  startAlpine();
});
