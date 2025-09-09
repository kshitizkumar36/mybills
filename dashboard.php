<?php
include 'login_check.php';
include 'backend_header.php';
include 'connection.php';
?>

<?php
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `trip` WHERE `created_by` = '$user_id'";
$result = mysqli_query($conn, $sql);
$total_person = 0;
while ($data_debit = mysqli_fetch_assoc($result)) {
  $total_person += $data_debit['people'];
}

$trip_count = mysqli_num_rows($result);


$sql = "SELECT * FROM `debits` WHERE `created_by` = '$user_id'";
$result = mysqli_query($conn, $sql);
$total_debit = 0;
while ($data_debit = mysqli_fetch_assoc($result)) {
  $total_debit += $data_debit['amount'];
}

$sql = "SELECT * FROM `trip` WHERE `created_by` = '$user_id' AND `status`=1";
$result = mysqli_query($conn, $sql);

$active_trip = mysqli_num_rows($result);

?>

<!-- Main Content -->
<main class="col-md-10 p-4">

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="glass-card p-3 text-center">
        <i class="bi bi-map-fill fs-2 text-primary"></i>
        <h6 class="fw-bold mt-2">Total Trips</h6>
        <p class="display-6 fw-bold"><?php echo $trip_count; ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="glass-card p-3 text-center">
        <i class="bi bi-currency-rupee fs-2 text-success"></i>
        <h6 class="fw-bold mt-2">Total Spent</h6>
        <p class="display-6 fw-bold">₹<?php echo number_format($total_debit, 2); ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="glass-card p-3 text-center">
        <i class="bi bi-people-fill fs-2 text-warning"></i>
        <h6 class="fw-bold mt-2">People</h6>
        <p class="display-6 fw-bold"><?php echo $total_person; ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="glass-card p-3 text-center">
        <i class="bi bi-flag fs-2 text-info"></i>
        <h6 class="fw-bold mt-2">Active Trip</h6>
        <p class="display-6 fw-bold"><?php echo $active_trip; ?></p>
      </div>
    </div>
  </div>

  <!-- Recent Trips -->
  <div class="glass-card p-4">
    <h4 class="fw-bold mb-3">🧳 Recent Trips</h4>
    <div class="table-responsive">
      <table class="table table-dark table-hover align-middle">
        <thead>
          <tr>
            <th>Trip</th>
            <th>Destination</th>
            <th>People</th>
            <th>Budget</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `trip` WHERE `created_by` = '$user_id' ORDER BY `id` DESC";
          $result = mysqli_query($conn, $sql);
          while ($trip_data = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
              <td><?php echo $trip_data['trip_name']; ?></td>
              <td><?php $destination_id=  $trip_data['destination'];
              
                  $destination_query= "SELECT `state_name` FROM `states` WHERE `state_id`='$destination_id'";
                  $run_destination= mysqli_query($conn,$destination_query);
                  $destination_data= mysqli_fetch_assoc($run_destination);
                  echo $destination_data['state_name'];
              ?></td>
              <td><?php echo $trip_data['people']; ?></td>
              <td>₹<?php 
              $trip_id=$trip_data['id'];
                $query_budget= "SELECT * FROM `credits` WHERE `trip_id`='$trip_id' AND `created_by`='$user_id'";
                $run_budget= mysqli_query($conn,$query_budget);
                $total_budget=0;
                while($data_budget= mysqli_fetch_assoc($run_budget))
                {
                  $total_budget+= $data_budget['amount'];
                }

                echo number_format($total_budget, 2); 

              ?></td>
              <td>
                <?php
                if ($trip_data['status'] == 0) {
                  echo '<span class="badge bg-danger">Cancelled</span>';
                } elseif ($trip_data['status'] == 1) {
                  echo '<span class="badge bg-warning text-dark">On-going</span>';
                } elseif ($trip_data['status'] == 2) {
                  echo '<span class="badge bg-success">Finished</span>';
                }
                ?>
              </td>

            </tr>

            <?php
          } ?>


        </tbody>
      </table>
    </div>
  </div>

</main>
</div>
</div>

<!-- Floating Add Button -->
<a href="new_trip.php" class="btn btn-lg btn-primary rounded-circle floating-btn exciting-btn">
  <i class="bi bi-plus-lg"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar Toggle JS -->
<script>
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');

  sidebarToggle.addEventListener('click', function (e) {
    e.stopPropagation(); // prevent bubbling
    if (window.innerWidth <= 767.98) {
      // Mobile: open/close sidebar
      sidebar.classList.toggle('show');
    } else {
      // Desktop: collapse
      sidebar.classList.toggle('collapsed');
    }
  });

  // Close sidebar when clicking outside (only mobile)
  document.addEventListener('click', function (e) {
    if (window.innerWidth <= 767.98) {
      if (sidebar.classList.contains('show') &&
        !sidebar.contains(e.target) &&
        !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove('show');
      }
    }
  });
</script>

</body>

</html>