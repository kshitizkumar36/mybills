<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>MyBills - Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="https://kshitizkumar.com/assets/img/klogo.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  
  ...
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
header.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1100;
  background: rgba(0, 0, 0, 0.9);
  backdrop-filter: blur(6px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Ensure content does not hide behind header */
body {
  padding-top: 56px; /* header ki height ke barabar */
}

    body {
  background: url('https://kshitizkumar.com/assets/img/hero-bg.png') no-repeat center center fixed;
  background-size: cover;
  color: #f8f9fa;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Overlay effect */
body::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6); /* dark overlay */
  z-index: -1;
}

    /* Sidebar Base */
    .sidebar {
      min-height: 100vh;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(12px);
      padding: 1.2rem;
      transition: all 0.3s ease;
    }

    /* Desktop Collapse */
    @media (min-width: 768px) {
      .sidebar.collapsed {
        width: 70px;
        padding: 1rem 0.5rem;
        text-align: center;
      }

      .sidebar.collapsed .nav-link span {
        display: none;
      }
    }

    /* Mobile Slide-In/Out */
    @media (max-width: 767.98px) {
      .sidebar {
        position: fixed;
        top: 56px;
        left: 0;
        height: 100%;
        width: 220px;
        z-index: 1050;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      /* Main content full width */
      main {
        width: 100% !important;
      }
    }

    body {
      background-color: #0d0d0d;
      color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    header.navbar {
      background: rgba(0, 0, 0, 0.9);
      backdrop-filter: blur(6px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .nav-link {
      color: #f8f9fa;
      font-weight: 500;
      border-radius: 10px;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 15px;
      transition: all 0.3s ease;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background: linear-gradient(90deg, #0d6efd33, #20c99733);
      color: #0d6efd;
      transform: translateX(5px);
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 16px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .glass-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4);
    }

    .exciting-btn {
      border-radius: 50px;
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
      transition: all 0.3s ease;
    }

    .exciting-btn:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 12px 28px rgba(13, 110, 253, 0.6);
    }

    .floating-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 999;
    }

    .logo-img {
      width: 40px;
      border-radius: 50%;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="navbar navbar-dark px-3">
    <div class="d-flex align-items-center">
      <img src="https://kshitizkumar.com/assets/img/klogo.png" class="logo-img me-2" alt="Logo">
      <a class="navbar-brand fw-bold" href="#">MyBills</a>
    </div>
    <div class="d-flex align-items-center gap-3">
      <button id="sidebarToggle" class="btn btn-outline-light btn-sm"><i class="bi bi-list"></i></button>
      <span class="fw-semibold">Hi, <?php echo $user_name??'NA'; ?></span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </header>

  <div class="container-fluid">

  <!-- success modal -->
<?php
session_start();
?>

<!-- success modal for anything -->
<div class="modal fade" id="signupSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content glass-card text-light rounded-4 shadow-lg">
      
      <!-- Header -->
      <div class="modal-header border-0 justify-content-center">
        <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo" class="rounded-circle shadow-lg me-2" width="50">
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
  document.addEventListener("DOMContentLoaded", function() {
    var successModal = new bootstrap.Modal(document.getElementById('signupSuccessModal'));
    successModal.show();
  });
</script>
<?php unset($_SESSION['success']); // 👈 ab unset karo JS trigger ke baad ?>
<?php endif; ?>


<!-- end of anything success message -->
<!-- ✅ Signup Success Modal -->
<div class="modal fade" id="signupSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content glass-card text-light rounded-4 shadow-lg">
      
      <!-- Header -->
      <div class="modal-header border-0 justify-content-center">
        <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo" class="rounded-circle shadow-lg me-2" width="50">
        <h5 class="modal-title fw-bold text-success">Signup Successful</h5>
      </div>

      <!-- Body -->
      <div class="modal-body text-center">
        <p id="signupSuccessMessage" class="lead"></p>
      </div>

      <!-- Footer -->
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-success exciting-btn" data-bs-dismiss="modal">
          <i class="bi bi-check-circle me-2"></i> Let's Login
        </button>
      </div>

    </div>
  </div>
</div>

  <!-- end of success modal -->
    <div class="row">

      <!-- Sidebar -->
    <nav id="sidebar" class="col-md-2 sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="dashboard.php" class="nav-link active"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
      <a href="trips.php" class="nav-link"><i class="bi bi-map"></i> <span>Trips</span></a>
    </li>
    <li class="nav-item">
      <a href="create_trip.php" class="nav-link"><i class="bi bi-plus-circle"></i> <span>Create New Trip</span></a>
    </li>
    <!-- <li class="nav-item">
      <a href="#" class="nav-link"><i class="bi bi-wallet2"></i> <span>Expenses</span></a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link"><i class="bi bi-gear"></i> <span>Settings</span></a>
    </li> -->
  </ul>
</nav>
