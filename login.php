<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Online Shop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="content/css/style.css"> <!-- Pastikan path ini sesuai dengan file style.css -->
  <style>
    /* CSS untuk animasi loading */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.8);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      display: none; /* Sembunyikan overlay secara default */
    }
    .spinner-border {
      width: 3rem;
      height: 3rem;
      border-width: .4em;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">Online Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <div class="container mt-5 pt-4">
    <div class="row mt-4">
      <div class="col-12">
        <h1 class="text-center">Login</h1>
      </div>
    </div>
    
    <div class="row mt-4 d-flex justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form id="loginForm" action="login_process.php" method="post"> <!-- Pastikan path ini sesuai dengan file login_process.php -->
              <div class="form-group">
                <label for="username">Username</label>
                <input type="username" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Login</button>
              <div class="text-center mt-3">
                <a href="register.php">Register</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Indikator loading -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // JavaScript untuk menampilkan indikator loading saat form dikirim
    document.getElementById('loginForm').addEventListener('submit', function() {
      document.getElementById('loadingOverlay').style.display = 'flex';
    });

    // Menampilkan alert jika parameter error ada di URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('error') === '1') {
      alert('Invalid username or password!');
    }
  </script>
</body>
</html>
