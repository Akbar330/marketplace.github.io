<?php
include 'koneksi.php';

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Mengambil data pengguna dari database berdasarkan user_id
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($user) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Pengguna</title>
        </head>
        <body>
            <h2>Edit Pengguna</h2>
            <form action="edit_user.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                <label for="name">Nama:</label><br>
                <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>"><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah"><br>
                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Pengguna tidak ditemukan!";
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses update data pengguna
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
    } else {
        // Jika password kosong, ambil password lama
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        $password = $user['password'];
        mysqli_stmt_close($stmt);
    }

    $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $password, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Pengguna berhasil diupdate.";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    echo "User ID tidak diberikan atau kosong!";
    echo "<br>GET: ";
    print_r($_GET);
    echo "<br>POST: ";
    print_r($_POST);
}

?>
