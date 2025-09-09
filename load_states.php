<?php
include 'connection.php';

if (isset($_POST['country_id'])) {
    $country_id = intval($_POST['country_id']);
    $query = "SELECT * FROM states WHERE country_id = $country_id ORDER BY state_name";
    $result = $conn->query($query);

    echo '<option value="">Select State</option>';
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['state_id']}'>{$row['state_name']}</option>";
        }
    }
}
