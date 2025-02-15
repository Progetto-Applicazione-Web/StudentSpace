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

  const toggleModal2 = () => {
    console.log("Check");
    modalCorsi.classList.toggle('open');
  };

  modalCorsiButton.forEach(button => {
    button.addEventListener('click', toggleModal2);
  });
})();

(function () {
  const modalTasksButton = document.querySelectorAll('.modalTasksButton');
  const modalTasks = document.getElementById('modalTasks');

  const toggleModal3 = () => {
    modalTasks.classList.toggle('open');
  };

  modalTasksButton.forEach(button => {
    button.addEventListener('click', toggleModal3);
  });
})();

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


// Modal Edit 


(function () {
  const modalEditTasseButton = document.querySelectorAll('.modalEditTasseButton');
  const modalEditTasse = document.getElementById('modalEditTasse');

  const toggleModalEdit1 = () => {
    console.log("Check");
    modalEditTasse.classList.toggle('open');
  };

  modalEditTasseButton.forEach(button => {
    button.addEventListener('click', toggleModalEdit1);
  });
})();

(function () {
  const modalEditCorsiButton = document.querySelectorAll('.modalEditCorsiButton');
  const modalEditCorsi = document.getElementById('modalEditCorsi');

  const toggleModalEdit2 = () => {
    console.log(modalEditCorsiButton);
    modalEditCorsi.classList.toggle('open');
  };

  modalEditCorsiButton.forEach(button => {
    button.addEventListener('click', toggleModalEdit2);
  });
})();

(function () {
  const modalEditTasksButton = document.querySelectorAll('.modalEditTasksButton');
  const modalEditTasks = document.getElementById('modalEditTasks');

  const toggleModalEdit3 = () => {
    console.log("Check");
    modalEditTasks.classList.toggle('open');
  };

  modalEditTasksButton.forEach(button => {
    button.addEventListener('click', toggleModalEdit3);
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