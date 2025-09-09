<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>MyBills - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)),
        url('https://kshitizkumar.com/assets/img/hero-bg.png') center/cover no-repeat;
      color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
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

    .form-check-label {
      font-size: 0.9rem;
    }
  </style>
</head>

<body>

  <div class="container">


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


<script>
  const urlParams = new URLSearchParams(window.location.search);
  const name = urlParams.get('signup_success');

  if (name) {
    document.addEventListener('DOMContentLoaded', function () {
      const message = `👋 Welcome, ${name}! You have successfully signed up.`;
      document.getElementById('signupSuccessMessage').innerText = message;

      const successModal = new bootstrap.Modal(document.getElementById('signupSuccessModal'));
      successModal.show();

      // Remove ?signup_success= from URL to prevent re-show
      const cleanUrl = window.location.origin + window.location.pathname;
      window.history.replaceState({}, document.title, cleanUrl);
    });
  }
</script>

    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="glass-card rounded-4 shadow-lg p-5">
          <div class="text-center mb-4">
            <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo"
              class="rounded-circle shadow-lg mb-3" width="100">
            <h2 class="fw-bold text-gradient">Hii Buddy </h2>
            <p class="small text-light">Login to access your trips & expenses.</p>
          </div>


          

          <!-- Login Form -->
          <form action="backend.php" method="post">

            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
              </div>
              <a href="forget.php" class="text-decoration-none text-primary small">Forgot password?</a>
            </div>

            <div class="d-grid">
              <button type="submit" name="login" class="btn btn-primary exciting-btn">
                Login <i class="bi bi-box-arrow-in-right ms-2"></i>
              </button>
            </div>
          </form>

          <!-- Signup Redirect -->
          <p class="text-center mt-4 small">Don�t have an account?
            <a href="signup.php" class="text-decoration-none text-success">Sign up here</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
