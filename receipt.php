<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Booking Receipt — ECG Gym</title>
<style>
  body{font-family:Arial,Helvetica,sans-serif;background:#f4f4f6;margin:0;padding:40px;display:flex;justify-content:center}
  .receipt{width:720px;background:#fff;padding:24px;border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,.08)}
  h2{margin-top:0}
  .row{display:flex;gap:12px;align-items:center}
  .label{color:#666;width:150px}
  .value{font-weight:600}
  .meta{margin-top:16px;color:#666}
  .printBtn{margin-top:20px;background:#5b42f3;color:#fff;padding:10px 14px;border-radius:8px;border:none;cursor:pointer}
</style>
</head>
<body>
  <div class="receipt" id="receiptBox">
    <h2>Booking Receipt</h2>
    <div id="content"></div>

    <div class="meta">This is your booking confirmation. Please save or print this page for your records.</div>
    <button class="printBtn" onclick="window.print()">Print Receipt</button>
  </div>

<script>
function getQueryParam(name){
  const url = new URL(window.location.href);
  return url.searchParams.get(name);
}

function loadBookings(){
  return JSON.parse(localStorage.getItem('ecg_bookings')||'[]');
}

function renderReceipt(booking){
  if(!booking){
    document.getElementById('content').innerHTML = '<p>No booking found. Maybe the booking ID is invalid.</p>';
    return;
  }
  const html = `
    <div style="display:flex;justify-content:space-between;align-items:center">
      <div>
        <div style="font-size:18px;font-weight:700">ECG Gym Fitness</div>
        <div style="color:#666">Training Booking Receipt</div>
      </div>
      <div style="text-align:right;color:#666">
        <div>Booking ID: <strong>${booking.id}</strong></div>
        <div>Date Created: ${new Date(booking.createdAt).toLocaleString()}</div>
      </div>
    </div>

    <hr style="margin:14px 0 18px;border:none;border-top:1px solid #eee">

    <div style="margin-bottom:10px">
      <div class="row"><div class="label">Client:</div><div class="value">[Client Name]</div></div>
      <div class="row"><div class="label">Trainer:</div><div class="value">${booking.trainerName}</div></div>
      <div class="row"><div class="label">Training Date:</div><div class="value">${booking.date}</div></div>
      <div class="row"><div class="label">Time:</div><div class="value">${booking.time}</div></div>
      <div class="row"><div class="label">Sessions:</div><div class="value">${booking.sessions}</div></div>
      <div class="row"><div class="label">Amount:</div><div class="value">₱${booking.amount}</div></div>
    </div>
  `;
  document.getElementById('content').innerHTML = html;
}

(function(){
  const id = getQueryParam('id');
  const bookings = loadBookings();
  const booking = bookings.find(b=>b.id === id);
  renderReceipt(booking);
})();
</script>
</body>
</html>
