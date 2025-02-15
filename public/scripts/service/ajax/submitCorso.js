$(document).ready(function () {
    $('#formAddCorso').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: '/corsi/add',
            type: 'POST',
            data: {
                nome: $('#nome').val(),
                codice: $('#codice').val(),
                cfu: $('#cfu').val(),
                docente: $('#docente').val(),
                anno_svolgimento: $('#anno_svolgimento').val(),
                stato_id: $('#stato').val(),
                note: $('#note').val(),
            },
            success: function (response) {
                // TODO: aggiungi corso nella pagina
                // TODO: chiudi modal
                // TODO: clear tutti input
            },
            error: function (response) {
                // TODO: segnali l'errore all'utente
            }
        });
    });
});