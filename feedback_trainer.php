<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Trainer Feedback</title>

<style>
  body{
    font-family: Arial, sans-serif;
    background:#eee;
    padding:20px;
    display:flex;
    justify-content:center;
  }
  .card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    width:400px;
    box-shadow:0 4px 15px rgba(0,0,0,0.15);
  }
  h2{margin-top:0;}
  label{display:block; margin-top:12px; font-weight:bold;}
  select, textarea{
    width:100%;
    padding:10px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #ccc;
  }
  textarea{height:120px; resize:none;}
  button{
    margin-top:18px;
    width:100%;
    padding:12px;
    background:#5b42f3;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
  }
  .success{
    background:#dff6dd;
    padding:12px;
    border-left:4px solid #27ae60;
    margin-top:20px;
    border-radius:6px;
    display:none;
  }
</style>

</head>
<body>

<div class="card">
  <h2>Trainer Feedback Form</h2>

  <label>Booking ID</label>
  <input type="text" id="bookingId" placeholder="Enter booking ID">

  <label>Trainer Name</label>
  <input type="text" id="trainerName" placeholder="Trainer's name">

  <label>Rating</label>
  <select id="rating">
    <option value="5">⭐⭐⭐⭐⭐ (5)</option>
    <option value="4">⭐⭐⭐⭐ (4)</option>
    <option value="3">⭐⭐⭐ (3)</option>
    <option value="2">⭐⭐ (2)</option>
    <option value="1">⭐ (1)</option>
  </select>

  <label>Comments</label>
  <textarea id="comments" placeholder="Write comments here..."></textarea>

  <button id="submitFeedback">Submit Feedback</button>

  <div class="success" id="successMsg">Feedback submitted successfully!</div>
</div>

<script>
/* -------------------------------
   SAVE FEEDBACK TO LOCALSTORAGE
   ------------------------------- */
document.getElementById('submitFeedback').onclick = function() {

  const bookingId = document.getElementById('bookingId').value.trim();
  const trainerName = document.getElementById('trainerName').value.trim();
  const rating = document.getElementById('rating').value;
  const comments = document.getElementById('comments').value.trim();

  if (!bookingId) { alert("Please enter a Booking ID."); return; }
  if (!trainerName) { alert("Please enter Trainer's name."); return; }

  const feedback = {
    bookingId,
    trainerName,
    rating,
    comments,
    date: new Date().toLocaleString()
  };

  // Fetch all feedbacks
  let all = JSON.parse(localStorage.getItem("trainer_feedback") || "[]");

  // Add new feedback
  all.push(feedback);

  // Save back to localStorage
  localStorage.setItem("trainer_feedback", JSON.stringify(all));

  // Show success message
  document.getElementById('successMsg').style.display = "block";

  // Clear fields
  document.getElementById('comments').value = "";
};
</script>

</body>
</html>