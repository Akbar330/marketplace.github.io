<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Jika tema diubah, simpan ke dalam sesi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $theme = $_POST['theme'];
    $_SESSION['theme'] = $theme;
    $message = "Tema berhasil diperbarui.";
}

// Ambil tema yang sedang digunakan
$current_theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings - Online Shop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link id="theme-stylesheet" rel="stylesheet" href="css/style-light.css"> <!-- Default theme -->
  <script>
    function changeTheme(theme) {
        var link = document.getElementById('theme-stylesheet');
        link.href = 'css/style-' + theme + '.css';
    }
  </script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="index.php">Online Shop</a>
  </nav>

  <div class="container mt-5 pt-4">
    <h1 class="text-center">Settings</h1>
    <div class="row mt-4">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
            <form method="POST" action="">
              <div class="form-group">
                <label for="theme">Choose Theme</label>
                <select class="form-control" id="theme" name="theme" onchange="changeTheme(this.value)" required>
                  <option value="light" <?php if ($current_theme == 'light') echo 'selected'; ?>>Light</option>
                  <option value="dark" <?php if ($current_theme == 'dark') echo 'selected'; ?>>Dark</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
