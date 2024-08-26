<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Optional: Hash the password if it was provided
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
    } else {
        // Retrieve the existing password if not updated
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        $password = $user['password'];
        mysqli_stmt_close($stmt);
    }

    // Update the user details
    $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $password, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "User berhasil diupdate.";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Request tidak valid!";
}
?>
