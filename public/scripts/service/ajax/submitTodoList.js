$(document).ready(function () {
    $task = [];
    $nTask = 0;

    $('#btnAddTask').on('click', function (event) {
        $taskTitolo =  $('#taskTitolo').val();

        if ($taskTitolo !== '') {
            $task.add($taskTitolo);

            // TODO: Aggiungi '[] -Titolo Task- (-)' alla lista delle tasca da aggiungere
        }
    });

    $('.btnRemoveTask').on('click', function (event) {
        $task.remove($('#taskTitolo').val());

    });

    $('#formAddTodoList').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: '/todolists/add',
            type: 'POST',
            data: {
                titolo: $('#titolo').val()
            },
            success: function (response) {
                // TODO: chiudi modal
                // TODO: clear tutti input
            },
            error: function (response) {
                // TODO: segnali l'errore all'utente
            }
        });
    });
});