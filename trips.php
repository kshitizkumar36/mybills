<?php
include'login_check.php';
include'backend_header.php';
?>
<style>
    .glass-card {
      background: rgba(255, 255, 255, 0.07);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 12px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .glass-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    }

    .glass-card .card-body p,
    .glass-card .card-body h6,
    .glass-card .card-footer small {
      color: rgba(255, 255, 255, 0.85);
      text-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
    }

    .glass-card .badge {
      font-weight: 600;
    }
</style>

      <!-- Main Content -->
      <main class="col-12 col-md-10 ms-sm-auto px-3">
        <?php
        include 'connection.php';
        session_start();
        $user_id= $_SESSION['user_id'];
        $query = "SELECT * FROM trip WHERE `created_by`='$user_id' ORDER BY created_on DESC";
        $result = mysqli_query($conn, $query);
        ?>

        <div class="container-fluid py-3">
          <div class="row g-3">
            <?php while ($row = mysqli_fetch_assoc($result)) { 
              //getting encruption id

             

              $key = "AES-256-CBC"; // Change this to a strong secret
$aes = new AESCipher($key);

$original =  $row['id'];
$encrypted_id = $aes->encrypt($original);

// $enc_user_id= $aes->encrypt($user_id);



// getting state name

$source_id = $row['source'];
$query_source_place = "SELECT * FROM states WHERE `state_id` = '$source_id'";
$run_source_place = mysqli_query($conn, $query_source_place);

if (!$run_source_place) {
    die("Query Failed: " . mysqli_error($conn));
}

$data_source = mysqli_fetch_assoc($run_source_place);


$destination_id = $row['destination'];
$query_destination_place = "SELECT * FROM states WHERE `state_id` = '$destination_id'";
$run_destination_place = mysqli_query($conn, $query_destination_place);

if (!$run_destination_place) {
    die("Query Failed: " . mysqli_error($conn));
}

$data_destination = mysqli_fetch_assoc($run_destination_place);



$_SESSION['trip_id']=$row['id'];

              ?>
              <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card glass-card border-0 shadow-sm rounded-3 h-100">
                  <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <h6 class="fw-bold text-truncate mb-0">
                        <i class="bi bi-map me-1 text-primary"></i>
                        <?php echo htmlspecialchars($row['trip_name']); ?>
                      </h6>
                      <span class="badge bg-<?php echo ($row['status'] == 'Active' ? 'success' : 'secondary'); ?> rounded-pill">
                        <?php echo htmlspecialchars($row['status']); ?>
                      </span>
                    </div>
                    <p class="mb-1 small"><i class="bi bi-geo-alt me-1"></i> <?php echo htmlspecialchars($data_source['state_name']); ?> → <?php echo htmlspecialchars($data_destination['state_name']); ?></p>
                    <p class="mb-1 small"><i class="bi bi-calendar-event me-1"></i>
                      <?php echo date("d M", strtotime($row['start_date'])); ?>
                      <?php if (!empty($row['end_date'])): ?> - <?php echo date("d M", strtotime($row['end_date'])); ?> <?php endif; ?>
                    </p>
                    <p class="mb-1 small"><i class="bi bi-cash-coin me-1"></i> ₹<?php echo number_format($row['budget']); ?></p>
                    <p class="mb-0 small"><i class="bi bi-people me-1"></i> <?php echo $row['people']; ?> People</p>
                  </div>
                  <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center p-2">
                    <small><i class="bi bi-clock me-1"></i> <?php echo date("d M y", strtotime($row['created_on'])); ?></small>
                    <a href="trip_details.php?id=<?php echo $encrypted_id; ?>&user_id=<?php echo $user_id;?>" class="btn btn-sm btn-outline-primary rounded-pill">View <i class="bi bi-arrow-right ms-1"></i></a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Sidebar Toggle JS -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    sidebarToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      if (window.innerWidth <= 767.98) {
        sidebar.classList.toggle('show');
      } else {
        sidebar.classList.toggle('collapsed');
      }
    });

    document.addEventListener('click', function(e) {
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
