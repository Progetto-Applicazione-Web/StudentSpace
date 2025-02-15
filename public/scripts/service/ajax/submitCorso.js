$(document).ready(function () {
    $('#formAddCorso').on('submit', function (event) {
        event.preventDefault();

        $icona = $('#icona').val();
        $nome = $('#nome').val();
        $codice = $('#codice').val();
        $cfu = $('#cfu').val();
        $docente = $('#docente').val();
        $anno_svolgimento = $('#anno_svolgimento').val();
        $stato_id = $('#stato').val();
        $note = $('#note').val();

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
            // TODO: aggiungi corso nella pagina
            $corsi = $('#corsi');



            // TODO: chiudi modal
            // TODO: clear tutti input
        },
        error: function (response) {
            // TODO: segnali l'errore all'utente
        }
    });
}