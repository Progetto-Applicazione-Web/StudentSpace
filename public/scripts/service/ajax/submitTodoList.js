$(document).ready(function () {
    var $tasksInput = [];
    var nTask = 0;
    $('#btnAddTask').on('click', function (event) {
      event.preventDefault();

      var taskDiv = $('<div></div>').addClass('flex gap-3');
      var newInput = $('<input type="text" placeholder="Task" />').addClass('border-1 outline-0 w-full p-3 border-dashed border-[var(--gray-color)] rounded-[10px]');
      var removeBtn = $('<button>-</button>').addClass('p bg-grayy font-bold text-whitee rounded-[10px] flex justify-center items-center h-12 aspect-square p-2 cursor-pointer hover:brightness-90 transition-all duration-500');
      taskDiv.append(newInput, removeBtn);
      $('#divAddTodoList').append(taskDiv);

      $tasksInput.push(newInput);
      nTask++;
  
      // Rimuove il task dinamico al click sul bottone "-"
      removeBtn.on('click', function (e) {
        e.preventDefault();
        taskDiv.remove();
      });
    });
  
    $('#formAddTodoList').on('submit', function (event) {
      event.preventDefault();

      var $tasks = [];

      $tasksInput.forEach(function ($taskInput) {
          $tasks.push(
              $taskInput.val()
          );
      })

      $.ajax({
        url: '/todolists/add',
        type: 'POST',
        data: {
          titolo: $('#titolo').val(),
          tasks: JSON.stringify($tasks)
        },
        success: function (response) {
            // TODO: Aggiungere la todolist alla pagina
            // TODO: Chiudi modal
           $('#formAddTodoList')[0].reset();
        },
        error: function (response) {
          // TODO: segnala l'errore all'utente
            response.message
        }
      });
    });
});
