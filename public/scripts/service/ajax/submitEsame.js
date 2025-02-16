$(document).ready(function () {
    $('#formAddEsame').on('submit', function (event) {
        event.preventDefault();

        var $nome = $('#nome').val();
        var $corso = $('#corso').val();
        var $data_svolgimento_raw = $('#data_svolgimento').val();
        var $data_svolgimento = $data_svolgimento_raw === '' ? '':new Date($data_svolgimento_raw).toLocaleDateString('it-IT');
        var $accettazione = $('input[name="accettazione"]:checked').val();
        var $voto = $('#voto').val();

        addEsame(
            $nome,
            $corso,
            $data_svolgimento,
            $accettazione,
            $voto
        );

    });
});

function addEsame($nome, $corso, $data_svolgimento, $accettazione, $voto) {
    $.ajax({
        url: '/esami/add',
        type: 'POST',
        data: {
            nome: $nome,
            corso: $corso,
            data_svolgimento: $data_svolgimento,
            accettazione: $accettazione,
            voto: $voto
        },
        success: function (response) {
            // TODO: Aggiungi esame
            // TODO: Chiudi modal

            // Clear Form
            $('#formAddEsame')[0].reset()
        },
        error: function (response) {
            // TODO:
        }
    });
}
