<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Bill Solution</title>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">My Bill Solution</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="credit.php">Credit Entry</a></li>
          <li class="nav-item"><a class="nav-link" href="debit.php">Debit Entry</a></li>
          <li class="nav-item"><a class="nav-link" href="credit.php">Credit History</a></li>
          <li class="nav-item"><a class="nav-link" href="debit.php">Debit History</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="container py-4">
    <div class="row align-items-center">
      <div class="col-6">
        <h2 class="mb-0">Kshitiz Invoice</h2>
      </div>
      <div class="col-6 text-end">
        <strong>For Vocman</strong>
      </div>
    </div>
  </header>