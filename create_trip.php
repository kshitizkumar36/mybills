<?php
include'connection.php';
if (isset($_POST['country_id'])) {
    $country_id = intval($_POST['country_id']);
    $query = "SELECT * FROM states WHERE country_id = $country_id ORDER BY state_name";
    $result = $conn->query($query);

    echo '<option value="">Select State</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['state_id']}'>{$row['state_name']}</option>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create New Trip - MyBills</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Placeholder text white/greyish readable color */
.form-control::placeholder {
    color: #bbb;   /* हल्का grey ताकि readable हो */
    opacity: 1;    /* कुछ browser opacity कम कर देते हैं */
}

/* Safari/Edge compatibility */
::-webkit-input-placeholder {
    color: #bbb;
}
:-ms-input-placeholder {
    color: #bbb;
}



        .form-control,
        .form-select {
            background: rgba(20, 20, 20, 0.85);
            border: none;
            color: #fff;
            border-radius: 12px;
            padding-left: 2.5rem;
        }

        .form-select option {
            background-color: #111;
            color: #fff;
        }

        body {
            background: url('https://kshitizkumar.com/assets/img/hero-bg.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: -1;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            animation: fadeInUp 0.8s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255, 255, 255, 0.18);
            outline: none;
            box-shadow: 0 0 12px rgba(13, 110, 253, 0.6);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #0d6efd;
            font-size: 1.3rem;
        }

        .exciting-btn {
            border-radius: 50px;
            padding: 14px 28px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.5);
            transition: all 0.3s ease;
        }

        .exciting-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 28px rgba(13, 110, 253, 0.7);
        }

        .logo-img {
            width: 45px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .page-title {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 10px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="container py-5">

    
  <!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content glass-card text-light rounded-4 shadow-lg">
      <div class="modal-header border-0 justify-content-center">
        <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo" class="rounded-circle shadow-lg me-2" width="50">
        <h5 class="modal-title fw-bold text-danger">😣I am in trouble!</h5>
      </div>
      <div class="modal-body text-center">
        <p id="errorMessage" class="lead"></p>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-danger exciting-btn" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-2"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>



        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="glass-card">

                    <!-- Title with Logo -->
                    <div class="page-title">
                        <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo" class="logo-img">
                        <h3 class="fw-bold text-white"><i class="bi bi-plus-circle me-2"></i>Create New Trip</h3>
                    </div>

                    <form action="backend.php" method="post" class="needs-validation" novalidate>

                        <!-- Trip Name -->
                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="bi bi-map"></i></span>
                            <input type="text" name="trip_name" class="form-control" placeholder="Enter trip name" required>
                        </div>

                        <!-- Source Country & State -->
                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold"><i class="bi bi-geo-alt me-1"></i> Source</label>
                            <div class="row g-2">
                                <div class="col-md-6 input-group">
                                    <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                    <select id="source_country" name="source_country" class="form-select" required>
                                        <option selected disabled>Select Country</option>
                                        <?php
                                        $result = $conn->query("SELECT * FROM countries ORDER BY country_name");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['country_id']}'>{$row['country_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select id="source_state" name="source_state" class="form-select" required>
                                        <option selected disabled>Select State</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Destination Country & State -->
                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold"><i class="bi bi-geo-alt-fill me-1"></i> Destination</label>
                            <div class="row g-2">
                                <div class="col-md-6 input-group">
                                    <span class="input-group-text"><i class="bi bi-flag-fill"></i></span>
                                    <select id="dest_country" name="dest_country" class="form-select" required>
                                        <option selected disabled>Select Country</option>
                                        <?php
                                        $result = $conn->query("SELECT * FROM countries ORDER BY country_name");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['country_id']}'>{$row['country_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 input-group">
                                    <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
                                    <select id="dest_state" name="dest_state" class="form-select" required>
                                        <option selected disabled>Select State</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="mb-3">
                            <label class="form-label text-light fw-semibold"><i class="bi bi-calendar-event me-1"></i> Trip Start Date</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                            <input type="number" name="budget" class="form-control" placeholder="Enter budget (₹)" required>
                        </div>

                        <!-- People -->
                        <div class="mb-4 input-group">
                            <span class="input-group-text"><i class="bi bi-people"></i></span>
                            <input type="number" name="people" class="form-control" placeholder="Enter number of people" required>
                        </div>

                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" name="new_trip" class="btn btn-primary exciting-btn w-100">
                                <i class="bi bi-check-circle me-2"></i> Create Trip
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadStates(countryId, stateDropdown) {
            $.ajax({
                url: "load_states.php",
                type: "POST",
                data: { country_id: countryId },
                success: function(data) {
                    $("#" + stateDropdown).html(data);
                }
            });
        }

        $("#source_country").change(function() {
            var countryId = $(this).val();
            loadStates(countryId, "source_state");
        });

        $("#dest_country").change(function() {
            var countryId = $(this).val();
            loadStates(countryId, "dest_state");
        });
    </script>
</body>

</html>
