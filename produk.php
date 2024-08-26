<?php
session_start();
include 'koneksi.php';

function getProducts($conn) {
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);
    return $result;
}

function getProductById($conn, $id_produk) {
    $sql = "SELECT * FROM produk WHERE id_produk=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function addProduct($conn, $nama_produk, $harga, $gambar, $desk) {
    $sql = "INSERT INTO produk (nama_produk, harga, gambar, desk) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdss', $nama_produk, $harga, $gambar, $desk);
    return $stmt->execute();
}

function updateProduct($conn, $id_produk, $nama_produk, $harga, $gambar, $desk) {
    $sql = "UPDATE produk SET nama_produk=?, harga=?, gambar=?, desk=? WHERE id_produk=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdssi', $nama_produk, $harga, $gambar, $desk, $id_produk);
    return $stmt->execute();
}

function deleteProduct($conn, $id_produk) {
    $sql = "DELETE FROM produk WHERE id_produk=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_produk);
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $desk = $_POST['desk'];

    // Handle file upload
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($gambar);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
    } else {
        $target_file = $_POST['existing_gambar'];
    }

    if (isset($_POST['id_produk'])) {
        // Update produk
        $id_produk = $_POST['id_produk'];
        updateProduct($conn, $id_produk, $nama_produk, $harga, $target_file, $desk);
    } else {
        // Add produk
        addProduct($conn, $nama_produk, $harga, $target_file, $desk);
    }
    header("Location: produk.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id_produk = $_GET['delete'];
    deleteProduct($conn, $id_produk);
    header("Location: produk.php");
    exit();
}

$editProduct = null;
if (isset($_GET['edit'])) {
    $id_produk = $_GET['edit'];
    $editProduct = getProductById($conn, $id_produk);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Daftar Produk</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = getProducts($conn);
                if ($products->num_rows > 0) :
                    while ($row = $products->fetch_assoc()) :
                ?>
                        <tr>
                            <td><?php echo $row['id_produk']; ?></td>
                            <td><?php echo $row['nama_produk']; ?></td>
                            <td><?php echo $row['harga']; ?></td>
                            <td><img src="<?php echo $row['gambar']; ?>" width="100"></td>
                            <td><?php echo $row['desk']; ?></td>
                            <td>
                                <a href="produk.php?edit=<?php echo $row['id_produk']; ?>" class="btn btn-warning">Edit</a>
                                <a href="produk.php?delete=<?php echo $row['id_produk']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus</a>
                            </td>
                        </tr>
                <?php
                    endwhile;
                else :
                ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada produk</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2><?php echo isset($editProduct) ? 'Edit' : 'Tambah'; ?> Produk</h2>
        <form action="produk.php" method="post" enctype="multipart/form-data">
            <?php if (isset($editProduct)) : ?>
                <input type="hidden" name="id_produk" value="<?php echo $editProduct['id_produk']; ?>">
                <input type="hidden" name="existing_gambar" value="<?php echo $editProduct['gambar']; ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $editProduct['nama_produk'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga" step="0.01" value="<?php echo $editProduct['harga'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
                <?php if (isset($editProduct)) : ?>
                    <img src="<?php echo $editProduct['gambar']; ?>" width="100">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="desk">Deskripsi:</label>
                <textarea class="form-control" id="desk" name="desk" required><?php echo $editProduct['desk'] ?? ''; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo isset($editProduct) ? 'Update' : 'Tambah'; ?> Produk</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
