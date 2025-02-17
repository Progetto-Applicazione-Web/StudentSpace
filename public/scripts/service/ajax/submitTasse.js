$(document).ready(function () {
  $('#formAddTassa').on('submit', function (event) {
    event.preventDefault();

    var importo = $('#importo').val();
    var scadenza = new Date($('#scadenza').val()).toLocaleDateString('it-IT');
    var descrizione = $('#descrizione').val();
    var pagato = $('#pagato').is(':checked');
    var dataPagamento = new Date($('#dataPagamento').val()).toLocaleDateString('it-IT');

    $.ajax({
      url: '/tasse/add',
      type: 'POST',
      data: {
        importo: importo,
        scadenza: scadenza,
        descrizione: descrizione,
        pagato: pagato,
        dataPagamento: dataPagamento
      },
      success: function (response) {
        // Costruisci la card della tassa rispettando lo stile Tailwind della pagina
        var card = '<div class="flex-col flex gap-5 bg-bg rounded-[30px] h-auto p-[20px] w-full lg:w-[450px]">';
        card += '  <span class="flex items-center justify-between">';
        card += '    <h2 class="heading-2 text-blackk !font-black">€ ' + importo + '</h2>';
        card += '    <p class="p text-grayy"> Scade ' + scadenza + '</p>';
        card += '  </span>';
        card += '  <p class="p text-blackk">' + descrizione + '</p>';
        
        if (pagato) {
          card += '  <p class="p text-grayy">Pagato il: ' + dataPagamento + '</p>';
        } else {
          card += '  <a class="bg-primary px-[20px] py-[15px] hover:brightness-110 active:brightness-75 transition-all w-full text-whitee p font-black rounded-[20px]">Paga</a>';
        }
        card += '</div>';

        $('#tasseContainer').append(card);
        $('#formAddTassa')[0].reset();
      },
      error: function (response) {
        // TODO: Mettere sulla pagina un errore
      }
    });
  });
});

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
