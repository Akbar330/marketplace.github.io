<?php
include 'koneksi.php';

$sql = "SELECT * FROM profil_toko";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Toko List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Profil Toko List</h2>
        <a href="create_profil_toko.php" class="btn btn-primary mb-3">Create Profil Toko</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama Toko</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Poto</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id_user']; ?></td>
                            <td><?php echo $row['nama_toko']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['no_hp']; ?></td>
                            <td><img src="uploads/<?php echo $row['poto']; ?>" alt="Poto" width="50"></td>
                            <td>
                                <a href="edit_profil_toko.php?id=<?php echo $row['id_user']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_profil_toko.php?id=<?php echo $row['id_user']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No profiles found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>
