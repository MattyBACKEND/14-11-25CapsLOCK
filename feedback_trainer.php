<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Trainer Feedback</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #808080;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.card{
    background:#fff;
    padding:40px;
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
.back-btn {
  display: inline-block;
  margin-bottom: 12px;
  text-decoration: none;
  color: #5b42f3;
  font-weight: bold;
  font-size: 14px;
}
.back-btn:hover {
  text-decoration: underline;
}
</style>
</head>
<body>

<div class="card">
<a href="TrainerBooking.php" class="back-btn">&larr; Back</a>

<h2>Trainer Feedback Form</h2>

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
document.getElementById('submitFeedback').onclick = function() {
    const rating = document.getElementById('rating').value;
    const comments = document.getElementById('comments').value.trim();

    if (!rating || !comments) {
        alert("Please provide both rating and comments.");
        return;
    }

    fetch('save_feedback.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ rating: rating, comment: comments })
    })
    .then(res => res.json())
    .then(response => {
        if(response.success){
            document.getElementById('successMsg').style.display = "block";
            document.getElementById('comments').value = "";
        } else {
            alert("Error: " + (response.error || "Unable to save feedback"));
        }
    })
    .catch(err => console.error(err));
};
</script>

</body>
</html>
