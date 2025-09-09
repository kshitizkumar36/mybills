<?php
include 'connection.php';
session_start();

$user_id = $_SESSION['user_id'];
$trip_id = $_GET['id'] ?? ($_SESSION['trip_id'] ?? 0);

$limit = 5;
$offset = $_GET['offset'] ?? 0;

$query = "SELECT * FROM debits 
          WHERE created_by='$user_id' AND trip_id='$trip_id' 
          ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}
echo json_encode($data);
