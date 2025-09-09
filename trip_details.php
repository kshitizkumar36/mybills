<?php

if (isset($_GET['id'])) {
  $encrypted_id = $_GET['id'];
  $user_id = $_GET['user_id'];
  include 'connection.php';
  // Use a strong secret key (not the cipher name!)
  $key = "AES-256-CBC"; // Change this to a strong secret
  $aes = new AESCipher($key);
  $decrypted_id = $aes->decrypt($encrypted_id);




  $check_trip = "SELECT * FROM `trip` WHERE `id`='$decrypted_id' LIMIT 1";
  $run_check_trip = mysqli_query($conn, $check_trip);

  if (!$run_check_trip || mysqli_num_rows($run_check_trip) == 0) {
    header("Location: error.php");
    exit();
  }
  // echo "Decrypted ID: " . htmlspecialchars($decrypted_id);
} else {
  header("Location: error.php");
  exit();
}


$trip_data = mysqli_fetch_assoc($run_check_trip);
$source_id = $trip_data['source'];
$query_source_place = "SELECT `state_name` FROM states WHERE `state_id` = '$source_id'";
$run_source_place = mysqli_query($conn, $query_source_place);

if ($run_source_place && mysqli_num_rows($run_source_place) > 0) {
  $row_source = mysqli_fetch_assoc($run_source_place);

} else {
  echo "Source not found!";
}


$destination_id = $trip_data['destination'];
$query_source_place = "SELECT `state_name` FROM states WHERE `state_id` = '$destination_id'";
$run_destination_place = mysqli_query($conn, $query_source_place);

if ($run_destination_place && mysqli_num_rows($run_destination_place) > 0) {
  $row_destination = mysqli_fetch_assoc($run_destination_place);

} else {
  echo "Destination not found!";
}





session_start();
$login_check = 0;
if (!$_SESSION['user_id']) {
  $login_check = 0;
} else {
  $login_check = 1;
  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['name'];
}




// getting dashboard total calculation


$trip_id = $decrypted_id;

$total_credits = "SELECT SUM(amount) AS total FROM credits WHERE trip_id='$trip_id' AND created_by='$user_id'";
$run_credits_sum = mysqli_query($conn, $total_credits);
$data_credits_sum = mysqli_fetch_assoc($run_credits_sum);

$total_amount_credit = $data_credits_sum['total'] ?? 0; // default 0 if no records


$total_debits = "SELECT SUM(amount) AS total FROM debits WHERE trip_id='$trip_id' AND created_by='$user_id'";
$run_debits_sum = mysqli_query($conn, $total_debits);
$data_debits_sum = mysqli_fetch_assoc($run_debits_sum);

$total_amount_debits = $data_debits_sum['total'] ?? 0; // default 0 if no records






?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Trip Report - <?php echo $trip_data['trip_name']; ?> Trip</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="https://kshitizkumar.com/assets/img/klogo.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* Force Dark Table */
    .table {
      background-color: #0d1117 !important;
      color: #f8f9fa !important;
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 12px;
      overflow: hidden;
    }

    .table th,
    .table td {
      background-color: #0d1117 !important;
      color: #f8f9fa !important;
      border-color: rgba(255, 255, 255, 0.1) !important;
    }

    .table thead th {
      background-color: #000 !important;
      color: #0dcaf0 !important;
    }

    .table tbody tr:hover td {
      background-color: rgba(0, 217, 255, 0.1) !important;
    }

    .table a {
      color: #0dcaf0 !important;
      text-decoration: none;
    }

    .table a:hover {
      text-decoration: underline;
    }

    body {
      background: #0d1117;
      color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Hero Section */
    .hero {
      background: url('https://kshitizkumar.com/assets/img/hero-bg.png') no-repeat center center/cover;
      padding: 6rem 1rem 4rem;
      text-align: center;
      position: relative;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
    }

    .hero-content {
      position: relative;
      z-index: 1;
    }

    .hero img {
      width: 150px;
      margin-bottom: 1rem;
      filter: drop-shadow(0 0 20px rgba(0, 153, 255, 0.8)) drop-shadow(0 0 40px rgba(0, 153, 255, 0.6));
      animation: glowPulse 2s infinite alternate;
    }

    @keyframes glowPulse {
      from {
        filter: drop-shadow(0 0 15px rgba(0, 153, 255, 0.7)) drop-shadow(0 0 30px rgba(0, 153, 255, 0.5));
      }

      to {
        filter: drop-shadow(0 0 25px rgba(0, 153, 255, 1)) drop-shadow(0 0 50px rgba(0, 153, 255, 0.8));
      }
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      color: #0dcaf0;
    }

    .hero p {
      font-size: 1.2rem;
      opacity: 0.9;
    }

    .badge-status {
      font-size: 1rem;
      padding: 0.5rem 1rem;
    }

    /* Stats Cards */
    .stats {
      margin-top: -3rem;
    }

    .stat-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 2rem;
      text-align: center;
      transition: transform 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .stat-card i {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      color: #0dcaf0;
    }

    .stat-card h4 {
      font-size: 1.3rem;
      margin-top: 0.5rem;
      font-weight: 600;
    }

    /* Section Title */
    .section-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      border-left: 5px solid #0dcaf0;
      padding-left: 10px;
    }

    .btn-success {
      background-color: #25D366 !important;
      /* WhatsApp green */
      border: none;
      border-radius: 30px;
      padding: 10px 20px;
      font-weight: 600;
      box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
      transition: all 0.3s ease;
    }

    .btn-success:hover {
      background-color: #1ebe5d !important;
      transform: translateY(-2px);
    }
  </style>
</head>

<body>
  <!-- Hero Section -->
  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo">
      <h1 style="
  font-size: clamp(1.5rem, 5vw, 3rem); 
  font-weight: 700; 
  color: #0dcaf0;
  display: -webkit-box; 
  -webkit-line-clamp: 2; 
  -webkit-box-orient: vertical; 
  overflow: hidden; 
  text-overflow: ellipsis;
">
        <?php echo $trip_data['trip_name']; ?> Trip
      </h1>

      <p><i class="bi bi-geo-alt-fill text-danger"></i> <?php echo $row_source['state_name']; ?> → <i
          class="bi bi-geo-fill text-success"></i> <?php echo $row_destination['state_name']; ?></p>
      <span class="badge bg-success badge-status">Active</span>

      <!-- WhatsApp Share Button -->
      <div class="mt-4">
        <a href="https://wa.me/?text=Check%20out%20our%20<?php echo $trip_data['trip_name']; ?>%20Trip%20Report:%20<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"
          target="_blank" class="btn btn-success btn-lg">
          <i class="bi bi-whatsapp"></i> Share on WhatsApp
        </a>
      </div>
    </div>
  </section>


  <!-- Stats Section -->
  <section class="container stats">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="stat-card">
          <i class="bi bi-wallet2"></i>
          <h4>₹<?php    echo  number_format($total_amount_credit, 0, '.', ','); ?></h4>
          <p>Budget(credits)</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <i class="bi bi-cash-coin"></i>
          <h4>₹<?php echo  number_format($total_amount_debits, 0, '.', ','); ?></h4>
          <p>Spent</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <i class="bi bi-graph-down"></i>
          <h4>₹<?php
            $remaining= $total_amount_credit-$total_amount_debits;
            echo  number_format($remaining, 0, '.', ',');
          ?></h4>
          <p>Remaining</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <i class="bi bi-people-fill"></i>
          <h4><?php echo $trip_data['people']; ?></h4>
          <p>People</p>
        </div>
      </div>
    </div>
  </section>


<section class="container stats mt-4">
  <div class="row g-4">

    <?php
    // Fetch category-wise total spent
    $cat_query = "
      SELECT mc.category, SUM(d.amount) AS total
      FROM debits d
      JOIN master_category mc ON d.invoice_for = mc.id
      WHERE d.trip_id = '$trip_id' AND d.created_by = '$user_id'
      GROUP BY mc.category
    ";
    $cat_result = mysqli_query($conn, $cat_query);

    // Icons mapping for categories
    $icons = [
      "Hotels/Rooms/PG" => "bi-building",
      "Fooding/Snacks/Break" => "bi-egg-fried",
      "Cab/Taxi/Bike/A" => "bi-car-front",
      "Shopping" => "bi-bag",
      "Miscellaneous" => "bi-box",
    ];

    // Loop through categories
    while ($row = mysqli_fetch_assoc($cat_result)) {
      $category = $row['category'];
      $total = $row['total'];
      $icon = $icons[$category] ?? "bi-circle"; // default icon if not mapped
    ?>
      <div class="col-md-3">
        <div class="stat-card">
          <i class="bi <?php echo $icon; ?>"></i>
          <h4>₹<?php echo number_format($total, 0, '.', ','); ?></h4>
          <p><?php echo $category; ?></p>
        </div>
      </div>
    <?php } ?>

  </div>
</section>

  <!-- success modal -->
  <?php
  session_start();
  ?>
  <!-- Dark Success Modal -->
  <div class="modal fade" id="signupSuccessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light rounded-4 shadow-lg border border-secondary">

        <!-- Header -->
        <div class="modal-header border-0 justify-content-center">
          <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo" class="rounded-circle shadow-lg me-2"
            width="50">
          <h5 class="modal-title fw-bold text-success">You know! 😁</h5>
        </div>

        <!-- Body -->
        <div class="modal-body text-center">
          <p id="signupSuccessMessage" class="lead">
            <?php
            if (isset($_SESSION['success'])) {
              echo $_SESSION['success'];
            }
            ?>
          </p>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-0 justify-content-center">
          <button type="button" class="btn btn-success exciting-btn" data-bs-dismiss="modal">
            <i class="bi bi-check-circle me-2"></i> Let's see...
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- Auto trigger modal if session has success -->
  <?php if (isset($_SESSION['success'])): ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        var successModal = new bootstrap.Modal(document.getElementById('signupSuccessModal'));
        successModal.show();
      });
    </script>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>



  <!-- Debit & Credit Tabs -->
  <section class="container my-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="debit-tab" data-bs-toggle="tab" data-bs-target="#debit" type="button"
          role="tab">Debit History</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="credit-tab" data-bs-toggle="tab" data-bs-target="#credit" type="button"
          role="tab">Credit History</button>
      </li>
    </ul>

    <div class="tab-content mt-4" id="myTabContent">
      <!-- Debit History -->
      <div class="tab-pane fade show active" id="debit" role="tabpanel">
        <h3 class="section-title">📉 Debit History</h3>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Invoice For</th>
                <th>Amount</th>
                <th>Date & Time</th>
                <th>Proof</th>
                <?php if ($login_check == 1) { ?>
                  <th>Action</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $query1 = "SELECT * FROM `debits` WHERE `created_by`='$user_id' AND `trip_id`='$decrypted_id' ORDER BY `id` desc";
              $run1 = mysqli_query($conn, $query1);

              while ($data1 = mysqli_fetch_assoc($run1)) {
                $cat_id = $data1['invoice_for'];
                $master_category = "SELECT `category` FROM `master_category` WHERE `id`='$cat_id'";
                $run_category = mysqli_query($conn, $master_category);
                $data_category = mysqli_fetch_assoc($run_category);
                ?>
                <tr>
                  <td><?php echo $data1['id']; ?></td>
                  <td><?php echo $data_category['category']; ?></td>
                  <td>₹<?php echo $data1['amount']; ?></td>
                  <td><?php echo $data1['date_time']; ?></td>
                  <td><a href="<?php echo $data1['proof']; ?>" target="_blank"><i class="bi bi-file-earmark-text"></i>
                      View</a></td>
                  <?php if ($login_check == 1) { ?>
                    <td>
                      <!-- Edit Button -->
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editModal<?php echo $data1['id']; ?>">
                        <i class="bi bi-pencil"></i>
                      </button>

                      <!-- Delete Button -->
                      <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteModal<?php echo $data1['id']; ?>">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  <?php } ?>
                </tr>


                <!-- ✅ Edit Modal -->
                <div class="modal fade" id="editModal<?php echo $data1['id']; ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content bg-dark text-light">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Debit #<?php echo $data1['id']; ?></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                      </div>
                      <form method="post" action="backend.php" enctype="multipart/form-data">
                        <div class="modal-body">
                          <input type="hidden" name="id" value="<?php echo $data1['id']; ?>">

                          <div class="mb-3">
                            <label class="form-label">Invoice For</label>


                            <select name="invoice_for" class="form-control bg-dark text-light border-secondary">
                              <option selected disabled>Please Select</option>
                              <?php
                              $query_category = "SELECT `id`, `category` FROM `master_category` WHERE `status`=1";
                              $run_category = mysqli_query($conn, $query_category);
                              while ($cat_data = mysqli_fetch_assoc($run_category)) {
                                ?>
                                <option <?php if ($data1['invoice_for'] == $cat_data['id']) {
                                  echo "selected";
                                } ?>
                                  value="<?php echo $cat_data['id']; ?>">
                                  <?php echo $cat_data['category']; ?>
                                </option>
                              <?php } ?>
                            </select>


                          </div>
                          <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;" type="number"
                              class="form-control" name="amount" value="<?php echo $data1['amount']; ?>" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Date & Time</label>
                            <input style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;" type="text"
                              class="form-control" name="date_time" value="<?php echo $data1['date_time']; ?>" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Proof (upload new if needed)</label>
                            <input style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;" type="file"
                              class="form-control" name="proof">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" name="edit_debit" class="btn btn-primary">Save Changes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- ✅ Delete Modal -->
                <div class="modal fade" id="deleteModal<?php echo $data1['id']; ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content bg-dark text-light text-center"> <!-- text-center to center logo -->

                      <!-- Logo with glow -->
                      <div class="mt-4">
                        <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo"
                          style="height: 80px; filter: drop-shadow(0 0 15px #00f);">
                      </div>

                      <!-- Modal Header -->
                      <div class="modal-header border-0 d-block">
                        <h5 class="modal-title text-info fw-bold mt-3">Delete Confirmation</h5>
                      </div>

                      <!-- Modal Body -->
                      <div class="modal-body">
                        <p>Are you sure you want to delete <strong>Debit #<?php echo $data1['id']; ?></strong>?</p>
                      </div>

                      <!-- Modal Footer -->
                      <div class="modal-footer">
                        <form method="post" action="backend.php">
                          <input type="hidden" name="id" value="<?php echo $data1['id']; ?>">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" name="delete_debit" class="btn btn-danger">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>


              <?php } ?>
            </tbody>
          </table>


        </div>
      </div>

      <!-- Credit History -->
      <div class="tab-pane fade" id="credit" role="tabpanel">
        <h3 class="section-title">💰 Credit History</h3>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Credit From</th>
                <th>Amount</th>
                <th>Date & Time</th>
                <th>Proof</th>
                <?php if ($login_check == 1) { ?>
                  <th>Action</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>




              <?php
              $query2 = "SELECT * FROM `credits` WHERE `created_by`='$user_id' AND `trip_id`='$decrypted_id' ORDER BY `id` desc";
              $run2 = mysqli_query($conn, $query2);

              while ($data_credit = mysqli_fetch_assoc($run2)) {

                ?>
                <tr>
                  <td><?php echo $data_credit['id']; ?></td>
                  <td><?php echo $data_credit['source']; ?></td>
                  <td>₹<?php echo $data_credit['amount']; ?></td>
                  <td><?php echo $data_credit['date_time']; ?></td>
                  <td><a href="<?php echo $data_credit['proof']; ?>" target="_blank"><i
                        class="bi bi-file-earmark-text"></i> View</a></td>
                  <?php if ($login_check == 1) { ?>
                    <td>
                      <!-- Edit Button -->
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editModalforcredit<?php echo $data_credit['id']; ?>">
                        <i class="bi bi-pencil"></i>
                      </button>

                      <!-- Delete Button -->
                      <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteModalforcredit<?php echo $data_credit['id']; ?>">
                        <i class="bi bi-trash"></i>
                      </button>


                      <!-- ✅ Edit Modal -->
                      <div class="modal fade" id="editModalforcredit<?php echo $data_credit['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content bg-dark text-light">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Debit #<?php echo $data_credit['id']; ?></h5>
                              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="post" action="backend.php" enctype="multipart/form-data">
                              <div class="modal-body">
                                <input type="hidden" name="id" value="<?php echo $data_credit['id']; ?>">

                                <div class="mb-3">
                                  <label class="form-label">Credit By</label>
                                  <input style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;" type="text"
                                    class="form-control" name="source" value="<?php echo $data_credit['source']; ?>"
                                    required>

                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Amount</label>
                                  <input style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;"
                                    type="number" class="form-control" name="amount"
                                    value="<?php echo $data_credit['amount']; ?>" required>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Date & Time</label>
                                  <input style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;" type="text"
                                    class="form-control" name="date_time" value="<?php echo $data_credit['date_time']; ?>"
                                    required>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Proof (upload new if needed)</label>
                                  <input style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;" type="file"
                                    class="form-control" name="proof">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_credit" class="btn btn-primary">Save Changes</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <!-- ✅ Delete Modal -->
                      <div class="modal fade" id="deleteModalforcredit<?php echo $data_credit['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content bg-dark text-light text-center"> <!-- text-center to center logo -->

                            <!-- Logo with glow -->
                            <div class="mt-4">
                              <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo"
                                style="height: 80px; filter: drop-shadow(0 0 15px #00f);">
                            </div>

                            <!-- Modal Header -->
                            <div class="modal-header border-0 d-block">
                              <h5 class="modal-title text-info fw-bold mt-3">Delete Confirmation</h5>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                              <p>Are you sure you want to delete <strong>Debit #<?php echo $data_credit['id']; ?></strong>?
                              </p>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                              <form method="post" action="backend.php">
                                <input type="hidden" name="id" value="<?php echo $data_credit['id']; ?>">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="delete_credit" class="btn btn-danger">Delete</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>


                    </td>
                  <?php } ?>
                </tr>
                <?php
              }
              ?>


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>


  <!-- action button to add debit and credit -->
  <!-- Floating Action Buttons -->

  <?php
  if ($login_check == 1) {

    ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index:1050;">
      <!-- Debit FAB -->
      <button class="btn btn-danger rounded-circle shadow-lg mb-2" data-bs-toggle="modal" data-bs-target="#addDebitModal"
        style="width:60px;height:60px;">
        <i class="bi bi-dash-circle-fill fs-3"></i>
      </button>
      <!-- Credit FAB -->
      <button class="btn btn-success rounded-circle shadow-lg" data-bs-toggle="modal" data-bs-target="#addCreditModal"
        style="width:60px;height:60px;">
        <i class="bi bi-plus-circle-fill fs-3"></i>
      </button>
    </div>

    <!-- Debit Modal -->
    <div class="modal fade" id="addDebitModal" tabindex="-1" aria-labelledby="addDebitModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header border-secondary">
            <h5 class="modal-title text-danger" id="addDebitModalLabel"><i class="bi bi-dash-circle"></i> Add Debit</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="backend.php" id="debitForm" enctype="multipart/form-data">
              <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
              <input type="hidden" value="<?php echo $decrypted_id; ?>" name="trip_id">
              <div class="mb-3">
                <label for="debitInvoice" class="form-label">Invoice For</label>
                <select name="debit_for" class="form-control bg-dark text-light border-secondary">
                  <option selected disabled>Please Select</option>
                  <?php
                  $query_category = "SELECT `id`, `category` FROM `master_category` WHERE `status`=1";
                  $run_category = mysqli_query($conn, $query_category);
                  while ($cat_data = mysqli_fetch_assoc($run_category)) {
                    ?>
                    <option value="<?php echo $cat_data['id']; ?>">
                      <?php echo $cat_data['category']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="debitAmount" class="form-label">Amount</label>
                <input type="number" class="form-control bg-dark text-light" id="debit_amount" name="debit_amount"
                  required>
              </div>
              <div class="mb-3">
                <label for="datetime" class="form-label">Date/Time</label>
                <input type="datetime-local" class="form-control bg-dark text-light border-secondary" id="datetime"
                  name="debit_datetime" required>
              </div>
              <div class="mb-3">
                <label for="debitProof" class="form-label">Proof (File/Link)</label>
                <input type="file" class="form-control bg-dark text-light" id="debitProof" name="debit_proof" required>
              </div>
              <button type="submit" name="add_debits" class="btn btn-danger w-100">Save Debit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Credit Modal -->
    <div class="modal fade" id="addCreditModal" tabindex="-1" aria-labelledby="addCreditModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header border-secondary">
            <h5 class="modal-title text-success" id="addCreditModalLabel"><i class="bi bi-plus-circle"></i> Add Credit
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="creditForm" method="post" action="backend.php" enctype="multipart/form-data">
               <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
              <input type="hidden" value="<?php echo $decrypted_id; ?>" name="trip_id">
              <div class="mb-3">
                <label for="creditFrom" class="form-label">Credit From</label>
                <input type="text" name="credit_source" class="form-control bg-dark text-light" id="creditFrom" required>
              </div>
              <div class="mb-3">
                <label for="creditAmount" class="form-label">Amount</label>
                <input type="number" name="credit_amount" class="form-control bg-dark text-light" id="creditAmount"
                  required>
              </div>

              <div class="mb-3">
                <label for="creditDateTime" class="form-label">Date & Time</label>
                <input type="datetime-local" class="form-control" id="creditDateTime" name="credit_datetime"
                  style="background-color: #1e1e1e; color: #fff; border-color: #6c757d;">

              </div>


              <div class="mb-3">
                <label for="creditProof" class="form-label">Proof (File/Link)</label>
                <input type="file" class="form-control bg-dark text-light" id="credit_proof" name="credit_proof">
              </div>
              <button type="submit" name="add_credit" class="btn btn-success w-100">Save Credit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php
  }
  ?>
  <!-- end of action button -->
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>