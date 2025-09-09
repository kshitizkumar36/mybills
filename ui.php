<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>MyBills Dashboard - Landing Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="https://kshitizkumar.com/assets/img/klogo.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  
  ...
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      background-color: #121212;
      color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    header.navbar {
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(6px);
    }

    footer {
      background: #000;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .glass-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
    }

    .text-gradient {
      background: linear-gradient(90deg, #0d6efd, #20c997);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .exciting-btn {
      font-size: 1.1rem;
      padding: 12px 26px;
      border-radius: 50px;
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
      transition: all 0.3s ease;
    }

    .exciting-btn:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 12px 28px rgba(13, 110, 253, 0.6);
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">
        <i class="bi bi-credit-card-2-front me-2 text-primary"></i> MyBills
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#expenses">Expenses</a></li>
        </ul>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <!-- Hero Section -->
  <section id="hero" class="d-flex align-items-center justify-content-center text-light"
    style="background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('https://kshitizkumar.com/assets/img/hero-bg.png') center/cover no-repeat; min-height: 100vh;">
    <div class="container text-center">
      <div class="glass-card d-inline-block p-4 rounded-4 shadow-lg mb-4">
        <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo" class="rounded-circle shadow-lg"
          width="160">
      </div>
      <h1 class="fw-bold display-5">Welcome to <span class="text-primary">MyBills</span></h1>
      <p class="lead fst-italic">Plan trips, split bills, and track expenses easily.</p>
      <!-- Get Started Button -->
      <a href="create_trip.php"><button class="btn btn-lg btn-primary exciting-btn mt-3">
        Get Started <i class="bi bi-arrow-right-circle ms-2"></i>
      </button></a>
    </div>
  </section>




  <!-- Features Section -->
  <section id="features" class="py-5 bg-dark text-light">
    <div class="container">
      <h2 class="fw-bold display-5 mb-5 text-gradient text-center">🚀 Features</h2>
      <div class="row g-4 text-center">

        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-lg h-100">
            <i class="bi bi-map-fill fs-1 text-primary mb-3"></i>
            <h5 class="fw-bold">Create Plans</h5>
            <p class="small">Choose destinations, set budgets, and customize your travel billing plans.</p>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-lg h-100">
            <i class="bi bi-people-fill fs-1 text-success mb-3"></i>
            <h5 class="fw-bold">Share with People</h5>
            <p class="small">Add participants, split costs, and share expense details instantly.</p>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-lg h-100">
            <i class="bi bi-credit-card-fill fs-1 text-warning mb-3"></i>
            <h5 class="fw-bold">Track Expenses</h5>
            <p class="small">Save and view your past expenses according to card type securely.</p>
          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- Features Section -->
  <section id="features" class="py-5 bg-dark text-light">
    <div class="container">
      <h2 class="fw-bold display-5 mb-5 text-gradient text-center">🚀 Why Use MyBills?</h2>
      <div class="row g-4 text-center">

        <!-- Card 1 -->
        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-lg h-100 d-flex flex-column justify-content-between">
            <div>
              <i class="bi bi-map-fill fs-1 text-primary mb-3"></i>
              <h5 class="fw-bold">Plan Your Trips</h5>
              <p class="small">
                Select destinations, set your budget, and create trip plans within minutes.
                No more messy notes – everything in one place!
              </p>
            </div>
            <a href="#signup" class="btn btn-outline-primary mt-3">Start Planning</a>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-lg h-100 d-flex flex-column justify-content-between">
            <div>
              <i class="bi bi-people-fill fs-1 text-success mb-3"></i>
              <h5 class="fw-bold">Split Bills Easily</h5>
              <p class="small">
                Add your friends & family, split costs instantly, and avoid awkward “who owes what” conversations
                forever.
              </p>
            </div>
            <a href="#signup" class="btn btn-outline-success mt-3">Invite Friends</a>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-lg-4">
          <div class="glass-card p-4 rounded-4 shadow-lg h-100 d-flex flex-column justify-content-between">
            <div>
              <i class="bi bi-credit-card-fill fs-1 text-warning mb-3"></i>
              <h5 class="fw-bold">Track Expenses</h5>
              <p class="small">
                Keep a secure record of every trip expense. Review old trips anytime, anywhere – your money, your
                history.
              </p>
            </div>
            <a href="#signup" class="btn btn-outline-warning mt-3">Track Now</a>
          </div>
        </div>

      </div>

      <!-- Call to Action -->
      <div class="text-center mt-5">
        <h3 class="fw-bold text-gradient">💡 Ready to simplify your trips & expenses?</h3>
        <a href="signup.php" class="btn btn-lg exciting-btn btn-primary mt-3">
          Create Your Free Account <i class="bi bi-arrow-right-circle ms-2"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Expenses Section -->
  <section id="expenses" class="py-5 text-light">
    <div class="container">
      <h2 class="fw-bold display-5 mb-4 text-gradient text-center">💳 Past Expenses</h2>
      <p class="lead text-center mb-5">Quick glance at your past trips & expenses.</p>
      <div class="row g-4">

        <div class="col-md-4">
          <div class="glass-card p-4 rounded-4 shadow-lg">
            <h6 class="fw-bold text-primary">Trip to Goa</h6>
            <p class="mb-1"><i class="bi bi-people-fill me-2"></i>4 People</p>
            <p class="mb-1"><i class="bi bi-credit-card me-2"></i>HDFC Credit Card</p>
            <p class="fw-bold text-success">₹12,500</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="glass-card p-4 rounded-4 shadow-lg">
            <h6 class="fw-bold text-primary">Shimla Family Trip</h6>
            <p class="mb-1"><i class="bi bi-people-fill me-2"></i>6 People</p>
            <p class="mb-1"><i class="bi bi-credit-card me-2"></i>SBI Debit Card</p>
            <p class="fw-bold text-success">₹25,000</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="glass-card p-4 rounded-4 shadow-lg">
            <h6 class="fw-bold text-primary">Jaipur Road Trip</h6>
            <p class="mb-1"><i class="bi bi-people-fill me-2"></i>3 People</p>
            <p class="mb-1"><i class="bi bi-credit-card me-2"></i>Axis Credit Card</p>
            <p class="fw-bold text-success">₹9,800</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-4 text-center text-light">
    <p class="mb-0">© 2025 MyBills Dashboard | Designed by <span class="text-primary">Kshitiz</span></p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>