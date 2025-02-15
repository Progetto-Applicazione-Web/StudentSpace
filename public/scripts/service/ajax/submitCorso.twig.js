$(document).ready(function () {
    $('#formAddCorso').on('submit', function (event) {
        event.preventDefault();

        var $icona = $('#icona').val();
        var $nome = $('#nome').val();
        var $codice = $('#codice').val();
        var $cfu = $('#cfu').val();
        var $docente = $('#docente').val();
        var $anno_svolgimento = $('#anno_svolgimento').val();
        var $stato_id = $('#stato').val();
        var $note = $('#note').val();

        addCorso(
            $icona,
            $nome,
            $codice,
            $cfu,
            $docente,
            $anno_svolgimento,
            $stato_id,
            $note
        );
    });
});

function addCorso($icona, $nome, $codice, $cfu, $docente, $anno_svolgimento, $stato_id, $note) {
    $.ajax({
        url: '/corsi/add',
        type: 'POST',
        data: {
            icona: $icona,
            nome: $nome,
            codice: $codice,
            cfu: $cfu,
            docente: $docente,
            anno_svolgimento: $anno_svolgimento,
            stato_id: $stato_id,
            note: $note,
        },
        success: function (response) {

            var $corsi = $('#corsi');
            // Costruisci l'HTML del nuovo corso in modo da rispettare lo stile Tailwind
            var nuovoCorso = '<div class="flex items-center justify-between px-[30px] py-[20px] border-2 br-bg rounded-[30px]">';
            nuovoCorso += '  <div class="flex items-center gap-5">';
            nuovoCorso += '      <p class="heading-1">' + $icona + '</p>';
            nuovoCorso += '      <div>';
            nuovoCorso += '          <h2 class="heading-2 text-blackk">' + $nome + '</h2>';
            nuovoCorso += '          <p class="p text-grayy">' + $docente + ' - ' + $anno_svolgimento + '° Anno</p>';
            nuovoCorso += '      </div>';
            nuovoCorso += '  </div>';
            if ($stato_id == 3 || $stato_id === "3") { 
                nuovoCorso += '  <img src="' + $corsi.attr("data-superato-icon-url") + '" alt="icona">';  
            }
            nuovoCorso += '</div>';

            // Aggiungi il nuovo corso nella pagina (all'interno del container con id "corsi")
            $corsi.append(nuovoCorso);

            // Chiudi il modal: nascondi il form, resetta gli input e poi lo mostra di nuovo
            $('#formAddCorso').fadeOut(300, function () {
                this.reset();
                $(this).show();
            });
        },
        error: function (response) {
            alert('Errore nell\'aggiungere il corso. Riprova.');
        }
    });
}
