(function () {
  const menuButtonn = document.getElementById('menuButtonn');
  const items = document.getElementById('items');

  const toggleMenu = () => {
    items.classList.toggle('open');
  };

  menuButtonn.addEventListener('click', toggleMenu);
})();

(function () {
  const pill = document.getElementById('pill');
  const dropdown = document.getElementById('dropdown');
  const arrow = document.getElementById('arrow');

  const toggleMenu2 = () => {
    dropdown.classList.toggle('!h-[100px]');
    arrow.classList.toggle('-rotate-90');
    dropdown.classList.toggle('mt-2');
    
    
  };

  pill.addEventListener('click', toggleMenu2);
})();