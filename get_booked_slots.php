<?php
include "connection.php";

$trainer_id = $_GET['trainer_id'];
$date = $_GET['date'];

$sql = "SELECT time FROM bookings WHERE trainer_id = ? AND date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $trainer_id, $date);
$stmt->execute();
$result = $stmt->get_result();

$times = [];
while($row = $result->fetch_assoc()){
    $times[] = $row["time"];
}

echo json_encode($times);
?>
