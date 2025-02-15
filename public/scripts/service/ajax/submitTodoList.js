$(document).ready(function () {
    // (eventuali variabili globali per i task se necessarie)
    var tasks = [];
    var nTask = 0;
  
    $('#btnAddTask').on('click', function (event) {
      event.preventDefault();
  
      // Crea un nuovo contenitore per il task dinamico
      var taskDiv = $('<div></div>').addClass('flex gap-3');
  
      // Crea il nuovo campo di input vuoto
      var newInput = $('<input type="text" placeholder="Task" />').addClass('border-1 outline-0 w-full p-3 border-dashed border-[var(--gray-color)] rounded-[10px]');
  
      // Crea il bottone per rimuovere il campo di input
      var removeBtn = $('<button>-</button>').addClass('p bg-grayy font-bold text-whitee rounded-[10px] flex justify-center items-center h-12 aspect-square p-2 cursor-pointer hover:brightness-90 transition-all duration-500');
  
      // Aggiunge l'input e il bottone al contenitore
      taskDiv.append(newInput, removeBtn);
  
      // Aggiunge il nuovo task dinamico al container identificato da #divAddTodoList
      $('#divAddTodoList').append(taskDiv);
  
      // Rimuove il task dinamico al click sul bottone "-"
      removeBtn.on('click', function (e) {
        e.preventDefault();
        taskDiv.remove();
      });
    });
  
    $('#formAddTodoList').on('submit', function (event) {
      event.preventDefault();
      $.ajax({
        url: '/todolists/add',
        type: 'POST',
        data: {
          titolo: $('#titolo').val()
          // Puoi includere qui anche i task dinamici, iterando su #divAddTodoList
        },
        success: function (response) {
          // TODO: chiudi modal
          // TODO: clear tutti input
        },
        error: function (response) {
          // TODO: segnala l'errore all'utente
        }
      });
    });
});
