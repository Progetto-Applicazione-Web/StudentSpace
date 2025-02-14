function initPopup() {
  const esse3Buttons = document.querySelectorAll('.esse3Button');
  const esse3Popup = document.getElementById('esse3Popup');

  if (!esse3Popup) return; // Evita errori se il popup non è sulla pagina attuale

  let hidden = true;

  const toggleMenu3 = () => {
    if (hidden == true) {
      esse3Popup.classList.add("popup-visible");
      esse3Popup.classList.remove("popup-hidden");
      hidden = false;
    } else if (hidden == false) {
      esse3Popup.classList.remove("popup-visible");
      esse3Popup.classList.add("popup-hidden");
      hidden = true;
    }
  };

  esse3Buttons.forEach(button => {
    button.removeEventListener('click', toggleMenu3); // Evita duplicati
    button.addEventListener('click', toggleMenu3);
  });
}

// Inizializza al caricamento della pagina
document.addEventListener("DOMContentLoaded", initPopup);

// Riassegna gli eventi quando il DOM cambia (per SPA, Turbolinks, AJAX)
document.addEventListener("turbo:load", initPopup);  
document.addEventListener("ajaxComplete", initPopup);
