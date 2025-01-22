(function () {
  const menuButtonn = document.getElementById('menuButtonn');
  const items = document.getElementById('items');

  const toggleMenu = () => {
    items.classList.toggle('open');
  };

  menuButtonn.addEventListener('click', toggleMenu);
})();
