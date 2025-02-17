(function () {
  const modalEsamiButton = document.querySelectorAll('.modalEsamiButton');
  const modalEsami = document.getElementById('modalEsami');

  const toggleModal4 = () => {
    console.log("Check");
    modalEsami.classList.toggle('open');
  };

  modalEsamiButton.forEach(button => {
    button.addEventListener('click', toggleModal4);
  });
})();



(function () {
  const modalEditEsamiButton = document.querySelectorAll('.modalEditEsamiButton');
  const modalEditEsami = document.getElementById('modalEditEsami');

  const toggleModalEdit4 = () => {
    console.log("Check");
    modalEditEsami.classList.toggle('open');
  };

  modalEditEsamiButton.forEach(button => {
    button.addEventListener('click', toggleModalEdit4);
  });
})();