<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
  die("You must be logged in to book a session.");
};

// Step 1: Get trainer_id from GET for form display
$trainer_id = $_GET['trainer_id'] ?? $_POST['trainer_id'] ?? null;
$trainer_id = $_GET['trainer_id'] ?? null;
if (!$trainer_id) die("Trainer not found.");

// Step 2: Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Always get trainer_id from POST
    $trainer_id = $_POST['trainer_id'];

    $session_count = intval($_POST['session_count']);
    $price_per_session = 50;
    $total_price = $session_count * $price_per_session;

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, trainer_id, session_count, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $user_id, $trainer_id, $session_count, $total_price);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;

        header("Location: TrainerBooking.php?receipt=1&booking_id=$booking_id&trainer_id=$trainer_id");
        exit();
    } else {
        echo "Booking failed: " . $conn->error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Booking & Payment — ECG Gym</title>
<style>
  :root{
    --bg:#dfd78b; --card:#fff; --accent:#5b42f3; --muted:#666; --danger:#e74c3c; --success:#27ae60;
  }
  *{box-sizing:border-box}
  body{font-family:Inter,system-ui,Arial; margin:0; background:var(--bg); color:#222; display:flex; justify-content:center; padding:40px;}
  .card{background:var(--card); border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,.12); padding:24px; width:480px;}
  h1{margin:0 0 12px; font-size:22px}
  .muted{color:var(--muted)}
  .flex{display:flex; justify-content:space-between; margin:8px 0}
  .btn{background:var(--accent); color:#fff; border:none; padding:12px; border-radius:8px; cursor:pointer; width:100%; margin-top:16px;}
  .calendar-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:6px; margin-top:12px;}
  .dayName{text-align:center; font-size:12px; color:var(--muted); font-weight:600}
  .day{min-height:44px; display:flex; align-items:center; justify-content:center; background:#f6f6f6; border-radius:8px; cursor:pointer; transition:all .12s}
  .day:hover{transform:translateY(-3px)}
  .day.disabled{background:#eee; color:#aaa; cursor:not-allowed; transform:none}
  .day.selected{background:var(--accent); color:#fff; font-weight:700}
  .slots{display:flex; flex-wrap:wrap; gap:8px; margin-top:14px}
  .slot{padding:8px 12px; border-radius:8px; background:#f0f0f0; cursor:pointer}
  .slot.booked{background:#ffd6d6; color:#a00; cursor:not-allowed}
  .slot.selected{background:var(--accent); color:#fff}
  .receipt{display:none; border-top:1px solid #ccc; margin-top:20px; padding-top:16px;}
  .success{color:var(--success); font-weight:700; margin-bottom:8px;}
  .summary{margin-top:16px; padding:12px; border-radius:8px; background:#f8f8ff; border:1px solid #eee}
  .right-align{text-align:right}
  .cal-header{display:flex; justify-content:space-between; align-items:center; margin-top:12px;}
  .cal-controls button{padding:4px 8px; border-radius:6px; border:none; background:#f2f2f2; cursor:pointer;}
</style>
</head>
<body>

<div class="card" id="bookingCard">
  <a href="TrainerBooking.php?trainer_id=<?php echo $trainer_id; ?>" 
   style="display:inline-block; margin-bottom:10px; text-decoration:none; color:#5b42f3; border:2px solid #5b42f3; padding:8px 14px; border-radius:8px;">
   ← Back
</a>
  <h1>Book Training Session</h1>
  <p class="muted">Pick a date on the calendar and select an available time slot.</p>

  <label for="sessions">Number of Sessions</label>
  <select id="sessions">
    <option value="1">1 session - ₱50</option>
    <option value="2">2 sessions - ₱100</option>
    <option value="5">5 sessions - ₱250</option>
  </select>

  <div class="cal-header">
    <button id="prevMonth">&lt;</button>
    <div id="monthYear" class="muted"></div>
    <button id="nextMonth">&gt;</button>
  </div>

  <div id="calendarContainer">
    <div class="calendar-grid" id="calendar"></div>
  </div>

  <div style="margin-top:12px">
    <div class="muted">Available Time Slots</div>
    <div class="slots" id="slotsContainer"></div>
  </div>

  <div class="summary">
    <div class="flex">
      <div><div class="muted">Selected Date</div><div id="selectedDate">—</div></div>
      <div class="right-align"><div class="muted">Selected Time</div><div id="selectedTime">—</div></div>
    </div>
    <div class="muted">Price: <strong id="price">₱50</strong></div>
  </div>

  <button id="proceedBtn" class="btn">Proceed to Payment →</button>
</div>

<div class="card" id="paymentCard" style="display:none">
  <h1>Payment</h1>
  <div class="flex"><span>Date:</span><span id="payDate">—</span></div>
  <div class="flex"><span>Time:</span><span id="payTime">—</span></div>
  <div class="flex"><span>Sessions:</span><span id="paySessions">—</span></div>
  <div class="flex"><span>Total:</span><span id="payPrice">₱0</span></div>
  <button id="payBtn" class="btn">Pay Now</button>

  <div class="receipt" id="receipt">
    <div class="success">Payment Successful!</div>
    <div class="flex"><span>Booking ID:</span><span id="receiptId">—</span></div>
    <div class="flex"><span>Date:</span><span id="receiptDate">—</span></div>
    <div class="flex"><span>Time:</span><span id="receiptTime">—</span></div>
    <div class="flex"><span>Sessions:</span><span id="receiptSessions">—</span></div>
    <div class="flex"><span>Total Paid:</span><span id="receiptPrice">₱0</span></div>
  </div>
</div>

<script>
    const baseSlots = ['08:00','10:00','13:00','15:00','17:00','19:00'];
    const slotCapacity = 1;
    let now = new Date();
    let viewYear = now.getFullYear();
    let viewMonth = now.getMonth();
    let selected = {date:null, slot:null};
    const calendarEl = document.getElementById('calendar');

    function formatDateYMD(y,m,d){ m=String(m+1).padStart(2,'0'); d=String(d).padStart(2,'0'); return `${y}-${m}-${d}`; }
    function loadBookings(){ return JSON.parse(localStorage.getItem('ecg_bookings')||'[]'); }
    function saveBookings(arr){ localStorage.setItem('ecg_bookings', JSON.stringify(arr)); }
    function countBookingsForSlot(ymd,time){ return loadBookings().filter(b=>b.date===ymd && b.time===time).length; }

function buildCalendar(year,month){
  calendarEl.innerHTML='';
  const dayNames=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
  dayNames.forEach(dn=>{ const el=document.createElement('div'); el.className='dayName'; el.textContent=dn; calendarEl.appendChild(el); });
  document.getElementById('monthYear').textContent = new Intl.DateTimeFormat('en', {month:'long'}).format(new Date(year,month)) + ' ' + year;

  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month+1,0).getDate();
    for(let i=0;i<firstDay;i++){ calendarEl.appendChild(document.createElement('div')); }

  for(let d=1; d<=daysInMonth; d++){
    const dayEl=document.createElement('div');
    dayEl.className='day'; dayEl.textContent=d;
    const ymd=formatDateYMD(year,month,d);
    if(Array.from(baseSlots).every(s=>countBookingsForSlot(ymd,s)>=slotCapacity)) dayEl.classList.add('disabled');
    else dayEl.onclick=()=>{ selected.date=ymd; selected.slot=null; renderSlots(); updateSummary(); document.querySelectorAll('.day').forEach(n=>n.classList.remove('selected')); dayEl.classList.add('selected'); };
    if(year===now.getFullYear() && month===now.getMonth() && d===now.getDate()) dayEl.style.outline='2px solid rgba(90,63,243,.12)';
    calendarEl.appendChild(dayEl);
  }
}
function renderSlots(){
  const container=document.getElementById('slotsContainer'); container.innerHTML='';
    if(!selected.date){ container.innerHTML='<div class="muted">Select a date to view slots.</div>'; return; }
        baseSlots.forEach(s=>{
        const btn=document.createElement('div'); btn.className='slot'; btn.textContent=s;
    if(countBookingsForSlot(selected.date,s)>=slotCapacity){ btn.classList.add('booked'); }
        else btn.onclick=()=>{ document.querySelectorAll('.slot').forEach(x=>x.classList.remove('selected')); btn.classList.add('selected'); selected.slot=s; updateSummary(); };
    container.appendChild(btn);
  });
}
const selectedDateEl=document.getElementById('selectedDate'), selectedTimeEl=document.getElementById('selectedTime'), priceEl=document.getElementById('price'), sessionsSel=document.getElementById('sessions');
function updateSummary(){ selectedDateEl.textContent=selected.date||'—'; selectedTimeEl.textContent=selected.slot||'—'; const sessions=Number(sessionsSel.value); let amount=sessions===1?50:(sessions===2?100:250); priceEl.textContent=`₱${amount}`; }
buildCalendar(viewYear,viewMonth);
renderSlots();

/* Month controls */
document.getElementById('prevMonth').onclick=()=>{ viewMonth--; if(viewMonth<0){ viewMonth=11; viewYear--; } buildCalendar(viewYear,viewMonth); renderSlots(); };
document.getElementById('nextMonth').onclick=()=>{ viewMonth++; if(viewMonth>11){ viewMonth=0; viewYear++; } buildCalendar(viewYear,viewMonth); renderSlots(); };

/* Proceed to Payment */
document.getElementById('proceedBtn').onclick=()=>{
  if(!selected.date||!selected.slot){ alert('Please select a date and time slot.'); return; }
  const sessions=Number(sessionsSel.value);
  const amount=sessions===1?50:(sessions===2?100:250);
  const booking={id:'bk_'+Date.now(),date:selected.date,time:selected.slot,sessions,amount};
  localStorage.setItem('selectedBooking',JSON.stringify(booking));
  document.getElementById('bookingCard').style.display='none';
  document.getElementById('paymentCard').style.display='block';
  document.getElementById('payDate').textContent=booking.date;
  document.getElementById('payTime').textContent=booking.time;
  document.getElementById('paySessions').textContent=booking.sessions;
  document.getElementById('payPrice').textContent=`₱${booking.amount}`;
};

/* Pay Now */
document.getElementById('payBtn').onclick = () => {

    const sessions = Number(document.getElementById('sessions').value);
    const amount = sessions === 1 ? 50 : (sessions === 2 ? 100 : 250);

    const data = new FormData();
    data.append("trainer_id", "<?php echo $trainer_id; ?>");
    data.append("date", selected.date);
    data.append("time", selected.slot);
    data.append("sessions", sessions);
    data.append("total_price", amount);

    fetch("save_booking.php", {
        method: "POST",
        body: data
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === "success") {

            document.getElementById('receipt').style.display = 'block';
            document.getElementById('receiptId').textContent = res.booking_id;
            document.getElementById('receiptDate').textContent = selected.date;
            document.getElementById('receiptTime').textContent = selected.slot;
            document.getElementById('receiptSessions').textContent = sessions;
            document.getElementById('receiptPrice').textContent = '₱' + amount;

            document.getElementById('payBtn').style.display = 'none';

            // Redirect to Trainer page after 2 seconds
            setTimeout(() => {
                window.location.href = 
                    "TrainerBooking.php?trainer_id=<?php echo $trainer_id; ?>&booking=success";
            }, 2000);

        } else {
            alert("Booking failed: " + res.msg);
        }
    });
};;
</script>

</body>
</html>