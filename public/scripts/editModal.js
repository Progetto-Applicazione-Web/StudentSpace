(function () {

  const modificaButton = document.querySelectorAll('.modificaButton');
  const eliminaButton = document.querySelectorAll('.eliminaButton');

  // Gestisce il comportamento di Modifica/Salva
  const toggleModalEdit1 = (event) => {
    const button = event.target; // Bottone Modifica/Salva cliccato
    const parent = button.closest(".inputParent"); // Genitore contenente gli input e il bottone Elimina
    const inputs = parent.querySelectorAll("input, select, textarea");
    const eliminaBtn = parent.querySelector('.eliminaButton');

    if (button.textContent === "Modifica") {
      // Abilita gli input e aggiunge la classe
      inputs.forEach(input => {
        input.removeAttribute("disabled");
        input.classList.add("input-outlines");
      });
      button.textContent = "Salva";  // Cambia in Salva
      button.id = "save";
      if (eliminaBtn) {
        eliminaBtn.textContent = "Annulla"; // Imposta Elimina in Annulla
      }
    } else if (button.textContent === "Salva") {
      // Disabilita gli input e rimuove la classe
      inputs.forEach(input => {
        input.setAttribute("disabled", "true");
        input.classList.remove("input-outlines");
      });
      button.textContent = "Modifica"; // Torna a Modifica
      button.id = "edit";
      if (eliminaBtn) {
        eliminaBtn.textContent = "Elimina"; // Torna a Elimina
      }
    }
  };

  // Gestisce il comportamento di Elimina/Annulla
  const toggleElimina = (event) => {
    const button = event.currentTarget; // Bottone Elimina/Annulla cliccato
    const parent = button.closest(".inputParent");
    const inputs = parent.querySelectorAll("input, select, textarea");
    const modificaBtn = parent.querySelector('.modificaButton');

    // Se il bottone è in stato "Annulla", ripristina lo stato
    if (button.textContent.trim() === "Annulla") {
      inputs.forEach(input => {
        input.setAttribute("disabled", "true"); // Disabilita gli input
        input.classList.remove("input-outlines");  // Rimuove la classe
      });
      button.textContent = "Elimina"; // Torna a Elimina
      if (modificaBtn) {
        modificaBtn.textContent = "Modifica"; // Ripristina anche il bottone Modifica
      }
      // Ferma la propagazione: così il listener che apre il popup non verrà eseguito
      event.stopImmediatePropagation();
    }
  };

  modificaButton.forEach(button => {
    button.addEventListener('click', toggleModalEdit1);
  });

  eliminaButton.forEach(button => {
    button.addEventListener('click', toggleElimina);
  });

})();
  
(function () {
  // Seleziona tutti i bottoni con la classe "eliminaButton"
  const eliminaButtons = document.querySelectorAll('.eliminaButton');
  // Seleziona l'elemento popup già presente nel DOM
  const confirmPopup = document.querySelector('.confirm-popup');

  eliminaButtons.forEach(button => {
    button.addEventListener('click', function (event) {
      // Ottieni il bottone corrente
      const currentButton = event.currentTarget;
      // Leggi il testo rimuovendo eventuali spazi
      const buttonText = currentButton.textContent.trim();
      console.log("Testo del bottone cliccato:", buttonText);
      // Se il testo è esattamente "Elimina", apri il popup
      if (buttonText === "Elimina") {
        confirmPopup.classList.add('open');
      }
    });
  });

  // Chiude il popup cliccando su qualsiasi bottone al suo interno:
  const popupButtons = confirmPopup.querySelectorAll('button');
  popupButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      confirmPopup.classList.remove('open');
    });
  });
})();
