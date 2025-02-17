$(document).ready(function () {

    // (Opzionale) Funzione di controllo per abilitare/disabilitare il pulsante
    // Se preferisci il secondo metodo, puoi aggiornare lo stato del pulsante in tempo reale.
    // In questo esempio, lasciamo il pulsante sempre abilitato in modo da poter mostrare l'alert.
    function checkFields() {
        var icona = $('#icona').val();
        var nome = $('#nome').val();
        var codice = $('#codice').val();
        var cfu = $('#cfu').val();
        var docente = $('#docente').val();
        var anno_svolgimento = $('#anno_svolgimento').val();
        var stato_id = $('#stato').val();

        // Se vuoi visualizzare un feedback visivo, potresti aggiungere una classe o simili.
        // Per questo esempio non modifichiamo il bottone.
    }

    // Aggiorna il controllo al variare degli input
    $('#icona, #nome, #codice, #cfu, #docente, #anno_svolgimento, #stato').on('keyup change', checkFields);


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


        // Controlla se uno dei campi obbligatori è vuoto
        if (!$icona || !$nome || !$codice || !$cfu || !$docente || !$anno_svolgimento || !$stato_id) {
            alert("Inserisci tutti i dati mancanti");
            return; // Interrompe l'esecuzione se manca qualche dato
        }

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
            $('#formAddCorso')[0].reset();

            $('#modalCorsi').removeClass('open');


        },
        error: function (response) {
            alert('Errore nell\'aggiungere il corso. Riprova.');
        }
    });
}

function editCorso($id, $icona, $nome, $codice, $docente, $anno_svolgimento, $cfu, $stato_id, $note) {
    $.ajax({
        url: '/corsi/edit',
        type: 'POST',
        data: {
            id: $id,
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
            // TODO: Edit on DOM
        },
        error: function (response) {
            alert('Errore nella modifica del corso. Riprova.');
        }
    });
}

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

$(document).ready(function () {
    $("[data-corso-id]").on("click", async function () {
        let corsoId = $(this).data("corso-id"); // Recupera l'ID
        try {
            let response = await fetch(`/corsi/get?id=${corsoId}`);
            if (!response.ok) throw new Error("Errore nel recupero dati");
            let corso = await response.json();
            toggleModalEdit(corso.id, corso.icona, corso.nome, corso.codice, corso.docente, corso.anno_svolgimento, corso.cfu, corso.stato_id, corso.note);

        } catch (error) {
            console.error("Errore:", error);
        }
    });
});

const toggleModalEdit = ($id, $icona, $nome, $codice, $docente, $anno_svolgimento, $cfu, $stato_id, $note) => {
    console.log($id, $icona, $nome, $codice, $docente, $anno_svolgimento, $cfu, $stato_id, $note);
    $('#modalEditCorsi').toggleClass('open');

    $("#iconaEdit").attr("value", $icona);
    $("#nomeEdit").attr("value", $nome);
    $("#anno_svolgimentoEdit").attr("value", $anno_svolgimento);

};



document.querySelectorAll('.modalEditCorsiButton').forEach(button => {
    button.addEventListener('click', toggleModalEdit);
});
