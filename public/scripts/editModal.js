
document.addEventListener("DOMContentLoaded", function () {
  // Seleziona i bottoni e il form
  const editButton = document.querySelector(".modificaButton");
  const saveButton = document.querySelector(".SalvaButton");
  const form = document.getElementById("formEditCorso");

  // Nascondi inizialmente il bottone Salva
  saveButton.style.display = "none";

  // Funzione per abilitare i campi e aggiungere il contorno
  editButton.addEventListener("click", function () {
    const fields = form.querySelectorAll("input, select, textarea");
    fields.forEach(function (field) {
      field.removeAttribute("disabled");
      field.classList.add("outline", "outline-dashed", "outline-gray-400");
    });
    // Cambia visibilità dei bottoni
    editButton.style.display = "none";
    saveButton.style.display = "inline-block";
  });

  // Funzione per disabilitare i campi e rimuovere il contorno
  saveButton.addEventListener("click", function () {
    const fields = form.querySelectorAll("input, select, textarea");
    fields.forEach(function (field) {
      field.setAttribute("disabled", "disabled");
      field.classList.remove("outline", "outline-dashed", "outline-gray-400");
    });
    // Cambia visibilità dei bottoni
    saveButton.style.display = "none";
    editButton.style.display = "inline-block";
  });
});

