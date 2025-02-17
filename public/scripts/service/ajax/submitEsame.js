$(document).ready(function () {
    $('#formAddEsame').on('submit', function (event) {
        event.preventDefault();

        var $nome = $('#nome').val();
        var $corso = $('#corso').val();
        var $data_svolgimento_raw = $('#data_svolgimento').val();
        var $data_svolgimento = $data_svolgimento_raw === '' ? '' : new Date($data_svolgimento_raw).toLocaleDateString('it-IT');
        var $accettazione = $('input[name="accettazione"]:checked').val();
        var $voto = $('#voto').val();


        // Controlla se uno dei campi obbligatori è vuoto
        if (!$nome || !$corso) {
            alert("Inserisci tutti i dati obbligatori");
            return; // Interrompe l'esecuzione se manca qualche dato    
        }

        addEsame(
            $nome,
            $corso,
            $data_svolgimento,
            $accettazione,
            $voto
        );

    });
});


function formatData(date) {
    let a = date.split("/");
    let day = a[0];
    let month = a[1];
    let year = a[2];
    return year + '-' + month + '-' + day;
}


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
            
            var accettazioneBool = $accettazione === "1";
            var cssDinamico;
            var cssDinamico2;

            if (accettazioneBool) {
                cssDinamico = 'bg-secondary text-whitee';
                cssDinamico2 = '<h2 class="heading-2">' + $voto + '</h2>';
            } else {
                cssDinamico = 'bg-whitee text-blackk';
                cssDinamico2 = '<button class="p bg-primary text-whitee px-[20px] py-[10px] rounded-[10px]">Modifica</button>';
            }

            // TODO: Aggiungi esame
            // Costruisci l'HTML per l'esame (stile base, poi lo modifichi con Tailwind)
            var examHTML = '<div class="flex flex-col  p-[20px] border-2 br-bg rounded-[20px] gap-3 ' + cssDinamico + ' ">';
            examHTML += '  <h2 class="heading-2">' + $nome + '</h2>';
            examHTML += '  <h2 class="p text-grayy">' + $('#corso').find(':selected').attr('data-corso') + '</h2>';
            examHTML += '  <span>';
            examHTML += cssDinamico2;
            examHTML += '  </span>';
            examHTML += '</div>';

            var targetColumn; // Dove inserire l'esame (esami_dafare o superati)

            // Debug: Verifica i valori prima di eseguire gli IF
            console.log("Nome:", $nome);
            console.log("Corso:", $corso);
            console.log("Data Svolgimento:", $data_svolgimento);
            console.log("Accettazione:", $accettazione);
            console.log("Voto:", $voto);

            // Se c'è un voto e l'accettazione è positiva, l'esame va in SUPERATI
            if ($voto) {
                if ($accettazione && $accettazione.trim().toLowerCase() === '1') {
                    targetColumn = $('#superati');
                } else {
                    targetColumn = $('#esami_dafare');
                }
            } else {
                // Se non c'è il voto, ma c'è una data
                if ($data_svolgimento) {
                    targetColumn = $('#esami_dafare');
                    // Se il calendario è definito, aggiungi l'evento
                    if (typeof calendar !== "undefined") {
                        calendar.addEvent({
                            title: $nome + ' - ' + $corso,
                            start: formatData($data_svolgimento),
                            allDay: true
                        });
                    }
                } else {
                    // Se non c'è né il voto né la data, l'esame va in DA FARE
                    targetColumn = $('#esami_dafare');
                }
            }

            // Se non c'è né il voto né la data, l'esame va comunque in DA FARE
            if (!$voto && !$data_svolgimento) {
                targetColumn = $('#esami_dafare');
            }


            // Debug: Controlla se targetColumn è corretta
            console.log("Target Column:", targetColumn.attr('id'));

            // Inserisci l'HTML dell'esame nella colonna target
            if (targetColumn.length) {
                targetColumn.append(examHTML);
            } else {
                console.error("Errore: targetColumn non trovata.");
            }






            // TODO: Chiudi modal
            $('#modalEsami').removeClass('open');

            // Clear Form
            $('#formAddEsame')[0].reset()
        },
        error: function (response) {
            // TODO:
        }
    });
}
