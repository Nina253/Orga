<?php
$id_etudiant = $_SESSION['client']['id'];
?>
<section class="calendar-card">
    <div class="cal-header">
        <button class="prev" aria-label="Mois précédent">&lt;</button>
        <div class="month-year">Octobre</div>
        <button class="next" aria-label="Mois suivant">&gt;</button>
    </div>

    <div class="cal-grid" role="grid">
        <div class="weekday">D</div>
        <div class="weekday">L</div>
        <div class="weekday">M</div>
        <div class="weekday">M</div>
        <div class="weekday">J</div>
        <div class="weekday">V</div>
        <div class="weekday">S</div>
        <!-- Les jours seront injectés ici par JS -->
    </div>

    <div class="today-info">
        <h3 id="selected-date-title">Aujourd'hui</h3>
        <ul id="event-list">
            <li>chargement</li>
        </ul>
    </div>
</section>

<style>
:root {
    --blue-600: #006FFF;
    --blue-500: #006FFF;
    --blue-400: #006FFF;
    --card-bg: var(--blue-500);
    --accent: #d0e4ff;
    --white: #ffffff;
}

/* Carte */
.calendar-card {
    width: 320px;
    max-width: 92vw;
    background: var(--card-bg);
    color: var(--white);
    border-radius: 16px;
    padding: 22px;
    box-shadow: 0 8px 18px rgba(36,82,170,0.18);
    font-family: "Segoe UI", Roboto, Arial, sans-serif;
}

/* Header du calendrier */
.calendar-card .cal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}
.calendar-card .month-year {
    font-weight: 800;
    font-size: 1.45rem;
    text-align: center;
    flex: 1;
}
.calendar-card .cal-header .prev,
.calendar-card .cal-header .next {
    background: transparent;
    color: var(--white);
    border: none;
    font-weight: 700;
    font-size: 1.1rem;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    cursor: pointer;
    opacity: 0.95;
}
.calendar-card .cal-header .prev:hover,
.calendar-card .cal-header .next:hover {
    transform: translateY(-1px);
}

/* Grille */
.calendar-card .cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 8px;
    align-items: center;
}

/* Jours de la semaine */
.calendar-card .weekday {
    text-align: center;
    font-weight: 700;
    font-size: 0.85rem;
    border-bottom: 2px solid rgba(255,255,255,0.25);
    padding-bottom: 6px;
}

/* Cases jours */
.calendar-card .day {
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: transparent;
    color: var(--white);
    font-weight: 700;
    box-sizing: border-box;
    border: 2px solid rgba(255,255,255,0.08);
}
.calendar-card .day.outside { opacity: 0.35; font-weight:600; }
.calendar-card .day:hover { background: rgba(255,255,255,0.08); cursor: pointer; }
.calendar-card .day.today { background: rgba(255,255,255,0.22); box-shadow: inset 0 -6px 0 rgba(255,255,255,0.05); }
.calendar-card .day.selected { background: var(--accent); color: #1f3c6e; border-color: rgba(0,0,0,0.06); }

/* Section "Aujourd'hui" */
.calendar-card .today-info {
    margin-top: 16px;
    background: transparent;
    color: #111827;
    padding-left: 0;
}
.calendar-card .today-info h3 {
    color: white;
    margin: 10px 0 6px 0;
    font-size: 1rem;
}
.calendar-card .today-info ul {
    margin-left: 20px;
    color: #111827;
    list-style: disc;
}
.calendar-card .today-info li {
    margin: 0px 0;
    color: white;
    text-align:left;
}

/* Responsive */
@media (max-width:420px){
    .calendar-card { padding:16px; width: 90vw; border-radius:12px;}
    .calendar-card .day { height:40px; font-weight:700; }
}
</style>

<script>
let idEtu = "<?php echo $id_etudiant; ?>";

function initCalendar(container){
    const monthNames = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    const calGrid = container.querySelector('.cal-grid');
    const monthYear = container.querySelector('.month-year');
    const prevBtn = container.querySelector('.prev');
    const nextBtn = container.querySelector('.next');

    let today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    let selectedDate = new Date(today);

    function render(month, year){
        monthYear.textContent = monthNames[month] + ' ' + year;

        // Supprimer les jours précédents
        while(calGrid.children.length > 7) calGrid.removeChild(calGrid.lastChild);

        const firstDay = new Date(year, month, 1);
        const startWeekDay = firstDay.getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const prevMonthDays = new Date(year, month, 0).getDate();

        // Jours du mois précédent
        for(let i=startWeekDay-1;i>=0;i--){
            const d = prevMonthDays - i;
            const el = document.createElement('div');
            el.className = 'day outside';
            el.textContent = d;
            calGrid.appendChild(el);
        }

        // Jours du mois courant
        for(let d=1; d<=daysInMonth; d++){
            const el = document.createElement('div');
            el.className='day';
            el.textContent=d;
            const thisDate = new Date(year, month, d);

            if(thisDate.toDateString() === today.toDateString()) el.classList.add('today');
            if(thisDate.toDateString() === selectedDate.toDateString()) el.classList.add('selected');

            el.addEventListener('click', ()=>{
    selectedDate = thisDate;
    render(currentMonth, currentYear);

    const dateKey = selectedDate.getFullYear() + "-" +
                    String(selectedDate.getMonth() + 1).padStart(2,'0') + "-" +
                    String(selectedDate.getDate()).padStart(2,'0');

    showEvents(dateKey);        // Pour le mini-calendrier
    if(window.showPageEvents){  // Pour la zone de droite de la page
        window.showPageEvents(dateKey);
    }
});


            calGrid.appendChild(el);
        }

        // Jours du mois suivant
        while(calGrid.children.length % 7 !== 0){
            const nextDay = calGrid.querySelectorAll('.day').length - (startWeekDay + daysInMonth) + 1;
            const el = document.createElement('div');
            el.className='day outside';
            el.textContent = nextDay;
            calGrid.appendChild(el);
        }
    }

    prevBtn.addEventListener('click',()=>{
        currentMonth--;
        if(currentMonth<0){ currentMonth=11; currentYear--; }
        render(currentMonth,currentYear);
    });

    nextBtn.addEventListener('click',()=>{
        currentMonth++;
        if(currentMonth>11){ currentMonth=0; currentYear++; }
        render(currentMonth,currentYear);
    });

    render(currentMonth,currentYear);
    const todayKey = today.getFullYear() + "-" +
                   String(today.getMonth() + 1).padStart(2, '0') + "-" +
                   String(today.getDate()).padStart(2, '0');
  showEvents(todayKey, true);


}

document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.calendar-card').forEach(initCalendar);
});
const monthNames = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];

function showEvents(dateKey){
    const title = document.querySelector('#selected-date-title');
    const ul = document.querySelector('#event-list');

    const dateObj = new Date(dateKey);
    const today = new Date();

    // Vérifier si la date sélectionnée est aujourd'hui
    const isToday = dateObj.toDateString() === today.toDateString();

    if(isToday){
        title.textContent = "Aujourd’hui :";
    } else {
        const day = dateObj.getDate();
        const monthNames = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
        const month = monthNames[dateObj.getMonth()];
        const year = dateObj.getFullYear();
        title.textContent = `${day} ${month} ${year}`;
    }

    ul.innerHTML = "<li>Chargement...</li>";

    fetch("/Orga/calendrier/events.php?action=get&date=" + dateKey + "&id_etu=" + idEtu)
    .then(r => r.json())
    .then(data => {
        ul.innerHTML = "";
        if(data.length === 0){
            ul.innerHTML = "<li>Aucun événement.</li>";
        } else {
            data.forEach(ev => {
                let li = document.createElement("li");
                li.innerHTML = `<strong>${ev.titre}</strong><br>${ev.description ?? ""}`;
                ul.appendChild(li);
            });
        }
    });
}



</script>
