const menuButton = document.getElementById('menuButton');
const items = document.getElementById('items');

// Funzione per aprire/chiudere il menù
const toggleMenu = () => {
  items.classList.toggle('open');
};

// Event listener per il pulsante del menù
menuButton.addEventListener('click', toggleMenu);