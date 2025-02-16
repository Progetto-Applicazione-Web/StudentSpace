// Variabile globale per memorizzare l'istanza del calendario
window.myCalendar = null;

function initEsamiPage() {
  const formAddEsame = document.getElementById('formAddEsame');
  if (!formAddEsame) return; // Esci se il form non è presente (pagina diversa)

  // Inizializza o reinizializza il calendario
  initializeCalendar();

  // Nascondi e disabilita inizialmente i campi dinamici
  hideAndDisable($('#svoltoFields'));
  hideAndDisable($('#pianificatoFields'));

  // Utilizza binding delegato per i radio "option" (Da Fare, Svolto, Pianificato)
  $(document).on('change', 'input[name="option"]', function() {
    const selected = $(this).val();
    if (selected === "1") { // Da Fare
      $('#svoltoFields, #pianificatoFields')
        .slideUp()
        .find('input, select, textarea')
        .prop('disabled', true);
    } else if (selected === "2") { // Svolto
      $('#svoltoFields')
        .slideDown()
        .find('input, select, textarea')
        .prop('disabled', false);
      $('#pianificatoFields')
        .slideUp()
        .find('input, select, textarea')
        .prop('disabled', true);
    } else if (selected === "3") { // Pianificato
      $('#pianificatoFields')
        .slideDown()
        .find('input, select, textarea')
        .prop('disabled', false);
      $('#svoltoFields')
        .slideUp()
        .find('input, select, textarea')
        .prop('disabled', true);
    }
  });

  // Gestione del submit in AJAX
  formAddEsame.addEventListener('submit', function(e) {
    e.preventDefault();

    // Raccogli i campi comuni
    const nome = formAddEsame.querySelector('[name="nome"]').value;
    const cfu = formAddEsame.querySelector('[name="cfu"]').value;
    const corso_id = formAddEsame.querySelector('[name="corso_id"]').value;
    const stato = formAddEsame.querySelector('input[name="option"]:checked')?.value; // 1: Da Fare, 2: Svolto, 3: Pianificato

    const dataToSend = { nome, cfu, corso_id, stato };

    // Campi aggiuntivi se "Svolto"
    if (stato === "2") {
      dataToSend.data_svolgimento = formAddEsame.querySelector('[name="data_svolgimento"]').value;
      dataToSend.superato = formAddEsame.querySelector('[name="superato"]').checked ? 1 : 0;
      dataToSend.voto = formAddEsame.querySelector('[name="voto"]').value;
      dataToSend.accetto_rifiuto = formAddEsame.querySelector('input[name="option2"]:checked')?.value;
    }
    // Campi aggiuntivi se "Pianificato"
    else if (stato === "3") {
      dataToSend.data_appello = formAddEsame.querySelector('[name="data_appello"]').value;
    }

    // Invia i dati via AJAX (fetch)
    fetch('/esami/add', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dataToSend)
    })
      .then(res => {
        if (!res.ok) throw new Error('Errore di rete o server');
        return res.json();
      })
      .then(response => {
        // In base allo stato, aggiungi l'esame nella colonna corretta
        if (response.stato == 1) {
          addToDaFare(response);
        } else if (response.stato == 2) {
          addToSuperati(response);
        } else if (response.stato == 3) {
          addToCalendar(response);
        }

        // Chiudi il modal e resetta il form
        const modalEsami = document.getElementById('modalEsami');
        if (modalEsami) {
          $(modalEsami).fadeOut(300, function() {
            formAddEsame.reset();
            hideAndDisable($('#svoltoFields'));
            hideAndDisable($('#pianificatoFields'));
          });
        }
      })
      .catch(err => {
        alert("Errore nell'aggiungere l'esame: " + err.message);
      });
  });
}

/**
 * Inizializza o reinizializza il calendario, salvando l'istanza in window.myCalendar
 */
function initializeCalendar() {
  const calendarEl = document.getElementById('calendar');
  if (calendarEl) {
    if (calendarEl._fullCalendar) {
      calendarEl._fullCalendar.destroy();
    }
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        start: 'title',
        center: '',
        end: 'prev,next'
      },
      height: 'auto'
    });
    calendar.render();
    calendarEl._fullCalendar = calendar;
    window.myCalendar = calendar;
  }
}

/**
 * Mostra e abilita tutti i campi in un container (usando jQuery)
 */
function showAndEnable($container) {
  if (!$container.length) return;
  $container.slideDown();
  $container.find('input, select, textarea').prop('disabled', false);
}

/**
 * Nasconde e disabilita tutti i campi in un container (usando jQuery)
 */
function hideAndDisable($container) {
  if (!$container.length) return;
  $container.slideUp();
  $container.find('input, select, textarea').prop('disabled', true);
}

/**
 * Aggiunge un esame "Da Fare" alla colonna centrale
 */
function addToDaFare(exam) {
  const container = document.getElementById('daFareContainer');
  if (!container) return;
  const card = `
    <div class="flex flex-col bg-whitee p-[20px] border-2 br-bg rounded-[20px] gap-3 text-blackk">
      <h2 class="heading-2">${exam.nome}</h2>
      <h2 class="p text-grayy">${exam.cfu} CFU</h2>
      <span class="flex gap-4">
        <button class="p bg-primary text-whitee px-[20px] py-[10px] rounded-[10px]">Programma</button>
        <button class="p text-secondary">Dettagli</button>
      </span>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', card);
}

/**
 * Aggiunge un esame "Superati" alla colonna sinistra
 */
function addToSuperati(exam) {
  const container = document.getElementById('superatiContainer');
  if (!container) return;
  let votoOTesto = exam.voto;
  if (votoOTesto === "IDO") {
    votoOTesto = "Idoneo";
  }
  const card = `
    <div class="flex flex-col bg-secondary p-[20px] rounded-[20px] gap-1 text-whitee">
      <h2 class="heading-2">${exam.nome}</h2>
      <h2 class="p">${exam.cfu} CFU</h2>
      <h2 class="heading-2">${votoOTesto || ''}</h2>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', card);
}

/**
 * Aggiunge un esame "Pianificato" come evento nel calendario (colonna destra)
 */
function addToCalendar(exam) {
  if (!window.myCalendar) return;
  if (!exam.data_appello) return;
  window.myCalendar.addEvent({
    title: exam.nome,
    start: exam.data_appello
  });
}

// Richiama l'inizializzazione in caso di caricamento o navigazione dinamica
document.addEventListener('DOMContentLoaded', initEsamiPage);
document.addEventListener('turbo:load', initEsamiPage);
document.addEventListener('routeChangeComplete', initEsamiPage);
