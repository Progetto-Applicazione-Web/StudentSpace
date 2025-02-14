(function () {
  const modalTasseButton = document.querySelectorAll('.modalTasseButton');
  const modalTasse = document.getElementById('modalTasse');

  const toggleModal1 = () => {
    console.log("Check");
    modalTasse.classList.toggle('open');
  };

  modalTasseButton.forEach(button => {
    button.addEventListener('click', toggleModal1);
  });
})();

(function () {
  const modalCorsiButton = document.querySelectorAll('.modalCorsiButton');
  const modalCorsi = document.getElementById('modalCorsi');

  const toggleModal1 = () => {
    console.log("Check");
    modalCorsi.classList.toggle('open');
  };

  modalCorsiButton.forEach(button => {
    button.addEventListener('click', toggleModal1);
  });
})();

(function () {
  const modalTasksButton = document.querySelectorAll('.modalTasksButton');
  const modalTasks = document.getElementById('modalTasks');

  const toggleModal1 = () => {
    console.log("Check");
    modalTasks.classList.toggle('open');
  };

  modalTasksButton.forEach(button => {
    button.addEventListener('click', toggleModal1);
  });
})();

(function () {
  const modalEsamiButton = document.querySelectorAll('.modalEsamiButton');
  const modalEsami = document.getElementById('modalEsami');

  const toggleModal1 = () => {
    console.log("Check");
    modalEsami.classList.toggle('open');
  };

  modalEsamiButton.forEach(button => {
    button.addEventListener('click', toggleModal1);
  });
})();