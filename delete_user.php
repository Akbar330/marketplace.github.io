<?php
include 'koneksi.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare the SQL statement to avoid SQL injection
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the user_id parameter to the statement
    mysqli_stmt_bind_param($stmt, 'i', $user_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "User berhasil dihapus.";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "User ID tidak diberikan!";
}
?>
