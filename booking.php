<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Booking — ECG Gym</title>
<style>
  :root{
    --bg:#dfd78b; --card:#fff; --accent:#5b42f3; --muted:#666; --danger:#e74c3c;
  }
  *{box-sizing:border-box}
  body{font-family:Inter,system-ui,Arial; margin:0; background:var(--bg); color:#222}
  .wrap{min-height:100vh; display:flex; align-items:flex-start; justify-content:center; padding:48px; gap:36px;}
  .card{background:var(--card); border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,.12); padding:22px;}
  .left{width:480px}
  h1{margin:0 0 6px; font-size:22px}
  p.lead{margin:0 0 18px; color:var(--muted)}
  label{display:block; font-weight:600; margin:10px 0 6px}
  select, button, input{font-size:15px}
  select{width:100%; padding:10px 12px; border-radius:8px; border:1px solid #bdbdbd}
  .btn{background:var(--accent); color:#fff; border:none; padding:12px 16px; border-radius:8px; cursor:pointer}
  .btn:disabled{opacity:.6; cursor:not-allowed}
  .muted{color:var(--muted); font-size:13px}

/* calendar card */
  .cal-card{width:360px; padding:18px}
  .cal-header{display:flex; align-items:center; justify-content:space-between; margin-bottom:12px}
  .cal-controls{display:flex; gap:8px; align-items:center}
  .cal-controls button{background:#f2f2f2;border:0;padding:6px 9px;border-radius:6px;cursor:pointer}
  .monthTitle{font-weight:700}

  .calendar-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:6px}
  .dayName{text-align:center; font-size:12px; color:var(--muted); font-weight:600}
  .day{min-height:44px; display:flex; align-items:center; justify-content:center; background:#f6f6f6; border-radius:8px; cursor:pointer; transition:all .12s}
  .day:hover{transform:translateY(-3px)}
  .day.disabled{background:#eee; color:#aaa; cursor:not-allowed; transform:none}
  .day.other{opacity:.45}
  .day.selected{background:var(--accent); color:#fff; font-weight:700}
  .day.today{outline:2px solid rgba(90,63,243,.12)}

  /* timeslots */
  .slots{display:flex; flex-wrap:wrap; gap:8px; margin-top:14px}
  .slot{padding:8px 12px; border-radius:8px; background:#f0f0f0; cursor:pointer}
  .slot.booked{background:#ffd6d6; color:#a00; cursor:not-allowed}
  .slot.selected{background:var(--accent); color:#fff}
  .meta{margin-top:10px; font-size:14px; color:var(--muted)}

  .summary{margin-top:16px; padding:12px; border-radius:8px; background:#f8f8ff; border:1px solid #eee}
  .flex {display:flex; gap:12px; align-items:center}
  .right-align {text-align:right}
</style>
</head>
<body>

<div class="wrap">

  <!-- LEFT: booking form -->
  <div class="card left">
    <h1>Book Training Session</h1>
    <p class="lead">Choose trainer, pick a date on the calendar and select an available time slot.</p>

    <label for="trainer">Trainer</label>
    <select id="trainer">
      <!-- filled by JS -->
    </select>

    <label for="sessions">Number of Sessions</label>
    <select id="sessions">
            <option>1 session - ₱50</option>
            <option>2 sessions - ₱100</option>
            <option>3 sessions - ₱150</option>
            <option>4 sessions - ₱200</option>
            <option>5 sessions - ₱250</option>
            <option>6 sessions - ₱300</option>
            <option>7 sessions - ₱350</option>
            <option>8 sessions - ₱400</option>
            <option>9 sessions - ₱450</option>
            <option>10 sessions - ₱500</option>
            <option>11 sessions - ₱550</option>
            <option>12 sessions - ₱600</option>
            <option>13 sessions - ₱650</option>
            <option>14 sessions - ₱700</option>
            <option>15 sessions - ₱750</option>
            <option>16 sessions - ₱800</option>
    </select>

    <div class="summary">
      <div class="flex">
        <div>
          <div class="muted">Selected Date</div>
          <div id="selectedDate">—</div>
        </div>
        <div style="flex:1"></div>
        <div class="right-align">
          <div class="muted">Selected Time</div>
          <div id="selectedTime">—</div>
        </div>
      </div>

      <div class="meta">Price: <strong id="price">₱50</strong></div>
    </div>

    <div style="margin-top:14px">
      <button id="bookBtn" class="btn" style="width:100%; margin-top:14px">Proceed to Payment →</button>
    </div>
  </div>

  <!-- RIGHT: calendar + timeslots -->
  <div class="card cal-card">
    <div class="cal-header">
      <div class="cal-controls">
        <button id="prevMonth">&lt;</button>
        <div class="monthTitle" id="monthYear"></div>
        <button id="nextMonth">&gt;</button>
      </div>
      <div class="muted">Today: <span id="todayLabel"></span></div>
    </div>

    <div class="calendar-grid" id="calendar">
      <!-- day names + days injected by JS -->
    </div>

    <div style="margin-top:12px">
      <div class="muted">Available Time Slots</div>
      <div class="slots" id="slotsContainer">
        <!-- slots injected -->
      </div>

      <div class="muted" style="margin-top:8px">Legend: <span style="background:#ffd6d6;padding:4px 8px;border-radius:6px;margin-left:8px">booked</span> <span style="background:var(--accent);color:#fff;padding:4px 8px;border-radius:6px;margin-left:8px">selected</span></div>
    </div>
  </div>

</div>

<script>
/* ---------- DATA / CONFIG ---------- */
const trainers = [
  { id: 't1', name: 'J.co' },
  { id: 't2', name: 'Dunkin Donut' },
  { id: 't3', name: 'Krispy dog' }
];

// time slots per day
const baseSlots = ['08:00','10:00','13:00','15:00','17:00','19:00'];

// capacity per slot (how many bookings allowed per trainer per slot)
const slotCapacity = 1; // set 1 for unique bookings; set >1 to allow multiple

/* ---------- UTIL ---------- */
function formatDateYMD(y,m,d){
  m = String(m+1).padStart(2,'0'); d = String(d).padStart(2,'0');
  return `${y}-${m}-${d}`;
}

function parseYMD(ymd){
  const [y,m,d]=ymd.split('-').map(x=>parseInt(x,10)); return {y,m:d?m-1:m-1,d:d};
}

/* ---------- localStorage helpers ---------- */
function loadBookings(){
  return JSON.parse(localStorage.getItem('ecg_bookings')||'[]');
}

function saveBookings(arr){
  localStorage.setItem('ecg_bookings', JSON.stringify(arr));
}

/* ---------- Render trainer select ---------- */
const trainerSelect = document.getElementById('trainer');
trainers.forEach(t=>{
  const o = document.createElement('option'); o.value=t.id; o.textContent=t.name; trainerSelect.appendChild(o);
});

/* ---------- Calendar logic ---------- */
const calendarEl = document.getElementById('calendar');
const monthYearEl = document.getElementById('monthYear');
const todayLabel = document.getElementById('todayLabel');
let now = new Date();
let viewYear = now.getFullYear();
let viewMonth = now.getMonth();
let selected = {date:null, slot:null, trainer:null};

todayLabel.textContent = now.toLocaleDateString();

const dayNames = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];

function buildCalendar(year, month){
  calendarEl.innerHTML = '';
  // day name headers
  for(let dn of dayNames){
    const dnEl = document.createElement('div'); dnEl.className='dayName'; dnEl.textContent = dn; calendarEl.appendChild(dnEl);
  }

  monthYearEl.textContent = `${new Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(year,month))} ${year}`;

  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month+1, 0).getDate();

  // previous month trailing days (blank)
  for(let i=0;i<firstDay;i++){ const e=document.createElement('div'); calendarEl.appendChild(e); }

  for(let d=1; d<=daysInMonth; d++){
    const dayEl = document.createElement('div');
    dayEl.className = 'day';
    dayEl.textContent = d;

    const ymd = formatDateYMD(year, month, d);

    // other month styling not needed since all days are current month
    // check disabled: if fully booked for selected trainer
    const disabled = isDateFullyBookedForTrainer(ymd, trainerSelect.value);

    if(disabled){
      dayEl.classList.add('disabled');
    } else {
      // clickable
      dayEl.onclick = ()=> {
        // set selected if not disabled
        selected.date = ymd;
        selected.slot = null;
        selected.trainer = trainerSelect.value;
        // mark selected class
        document.querySelectorAll('.day').forEach(n=>n.classList.remove('selected'));
        dayEl.classList.add('selected');
        renderSlotsForSelected();
        updateSummary();
      };
    }

    // mark today
    const isToday = (year===now.getFullYear() && month===now.getMonth() && d===now.getDate());
    if(isToday) dayEl.classList.add('today');

    calendarEl.appendChild(dayEl);
  }
}

/* ---------- Booking data query helpers ---------- */
function bookingsForTrainerDate(trainerId, ymd){
  const all = loadBookings();
  return all.filter(b => b.trainer === trainerId && b.date === ymd);
}

function countBookingsForTrainerSlot(trainerId, ymd, time){
  const list = bookingsForTrainerDate(trainerId, ymd);
  return list.filter(b => b.time === time).length;
}

function isDateFullyBookedForTrainer(ymd, trainerId){
  // if every slot has >= slotCapacity bookings -> fully booked
  for(let s of baseSlots){
    if(countBookingsForTrainerSlot(trainerId, ymd, s) < slotCapacity){
      return false; // found available slot
    }
  }
  return true;
}

/* ---------- Slots rendering ---------- */
const slotsContainer = document.getElementById('slotsContainer');

function renderSlotsForSelected(){
  slotsContainer.innerHTML = '';
  if(!selected.date || !selected.trainer){
    slotsContainer.innerHTML = '<div class="muted">Select a trainer and a date to view available slots.</div>';
    return;
  }
  const trainerId = selected.trainer;
  for(let s of baseSlots){
    const btn = document.createElement('div');
    btn.className = 'slot';
    btn.textContent = s;

    const bookedCount = countBookingsForTrainerSlot(trainerId, selected.date, s);
    if(bookedCount >= slotCapacity){
      btn.classList.add('booked');
      btn.title = 'Fully booked';
    } else {
      btn.onclick = () => {
        // clear previous selected
        document.querySelectorAll('.slot').forEach(x=>x.classList.remove('selected'));
        btn.classList.add('selected');
        selected.slot = s;
        updateSummary();
      };
    }

    slotsContainer.appendChild(btn);
  }
}

/* ---------- UI: update summary / price ---------- */
const selectedDateEl = document.getElementById('selectedDate');
const selectedTimeEl = document.getElementById('selectedTime');
const priceEl = document.getElementById('price');
const sessionsSel = document.getElementById('sessions');

function updateSummary(){
  selectedDateEl.textContent = selected.date || '—';
  selectedTimeEl.textContent = selected.slot || '—';
  const sessions = Number(sessionsSel.value);
  let amount = 50; // base for 1
  if(sessions===1) amount = 50;
  if(sessions===2) amount = 100;
  if(sessions===5) amount = 250;
  priceEl.textContent = `₱${amount}`;
}

/* ---------- Month controls ---------- */
document.getElementById('prevMonth').onclick = ()=>{
  viewMonth--;
  if(viewMonth<0){ viewMonth=11; viewYear--; }
  buildCalendar(viewYear, viewMonth);
};

document.getElementById('nextMonth').onclick = ()=>{
  viewMonth++;
  if(viewMonth>11){ viewMonth=0; viewYear++; }
  buildCalendar(viewYear, viewMonth);
};

/* ---------- trainer change ---------- */
trainerSelect.onchange = ()=>{
  // if a date already selected, re-evaluate disabled status and slots
  if(selected.date && selected.trainer !== trainerSelect.value){
    selected.slot = null;
    selected.trainer = trainerSelect.value;
    updateSummary();
  }
  buildCalendar(viewYear, viewMonth);
  renderSlotsForSelected();
};

/* ---------- book action ---------- */
document.getElementById('bookBtn').onclick = ()=>{
  if(!selected.trainer){
    alert('Please select a trainer.');
    return;
  }
  if(!selected.date){
    alert('Please select a date in the calendar.');
    return;
  }
  if(!selected.slot){
    alert('Please select a time slot.');
    return;
  }
  // check slot still available
  const c = countBookingsForTrainerSlot(selected.trainer, selected.date, selected.slot);
  if(c >= slotCapacity){
    alert('Sorry, that time was booked just now. Please choose another slot.');
    renderSlotsForSelected();
    return;
  }

  // create booking
  const all = loadBookings();
  const id = 'bk_' + Date.now();
  const sessions = Number(sessionsSel.value);
  const amount = (sessions===1?50:(sessions===2?100:250));
  const trainerName = trainers.find(t=>t.id===selected.trainer).name;

  const booking = {
    id, trainer:selected.trainer, trainerName,
    date:selected.date, time:selected.slot,
    sessions, amount,
    createdAt: new Date().toISOString()
  };
  all.push(booking);
  saveBookings(all);

  // if date now fully booked, rebuild calendar to disable it
  buildCalendar(viewYear, viewMonth);

  // redirect to receipt page with id
  window.location.href = `receipt.html?id=${encodeURIComponent(id)}`;
};

/* ---------- initial load ---------- */
(function init(){
  // set default trainer
  trainerSelect.value = trainers[0].id;
  // build calendar
  buildCalendar(viewYear, viewMonth);
  renderSlotsForSelected();
  updateSummary();
})();
</script>
</body>
</html>
