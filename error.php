<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Error - Trip Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="https://kshitizkumar.com/assets/img/klogo.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #f8f9fa;
      background: #0d1117;
    }

    /* Hero Section */
    .hero {
      background: url('https://kshitizkumar.com/assets/img/hero-bg.png') no-repeat center center/cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      position: relative;
      text-align: center;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
    }

    .hero-content {
      position: relative;
      z-index: 1;
    }

    .hero img {
      width: 130px;
      margin-bottom: 1.5rem;
      filter: drop-shadow(0 0 20px rgba(0, 153, 255, 0.8))
              drop-shadow(0 0 40px rgba(0, 153, 255, 0.6));
      animation: glowPulse 2s infinite alternate;
    }

    @keyframes glowPulse {
      from {
        filter: drop-shadow(0 0 15px rgba(0, 153, 255, 0.7))
                drop-shadow(0 0 30px rgba(0, 153, 255, 0.5));
      }
      to {
        filter: drop-shadow(0 0 25px rgba(0, 153, 255, 1))
                drop-shadow(0 0 50px rgba(0, 153, 255, 0.8));
      }
    }

    h1 {
      font-size: 2.8rem;
      color: #0dcaf0;
      font-weight: bold;
    }

    p {
      font-size: 1.2rem;
      opacity: 0.9;
    }

    .btn-home {
      margin-top: 2rem;
      background-color: #0dcaf0;
      border: none;
      color: #fff;
      font-weight: 600;
      padding: 12px 26px;
      border-radius: 30px;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .btn-home:hover {
      background-color: #0bb2d4;
      transform: translateY(-3px);
    }
  </style>
</head>
<body>
  <section class="hero">
    <div class="hero-content">
      <img src="https://kshitizkumar.com/assets/img/klogo.png" alt="Logo">
      <h1>Oops! You did something wrong !! ☹</h1>
      <p>No trip data found. The link you followed may be invalid or expired.</p>
      <a href="index.php" class="btn-home"><i class="bi bi-house-door-fill"></i> Go Back Home</a>
    </div>
  </section>
</body>
</html>
