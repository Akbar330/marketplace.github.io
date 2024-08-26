<?php
session_start();
include 'koneksi.php';
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Shop Dashboard</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="row mt-3">
  <div class="col-12 d-flex justify-content-center">
    <div class="search-bar">
      <form action="search.php" method="GET" class="d-flex">
        <input type="text" name="query" class="form-control" placeholder="Search...">
        <button class="btn btn-outline-secondary" type="submit">
          <img src="https://img.icons8.com/ios-filled/24/000000/search.png" alt="Search">
        </button>
      </form>
    </div>
  </div>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">Online Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="wishlist.php">
            <img src="https://img.icons8.com/ios-filled/50/000000/like.png" alt="Wishlist" class="icon">
            Wishlist
          </a>
          <a class="nav-link" href="cart.php">
            <img src="https://img.icons8.com/ios-filled/50/000000/shopping-cart.png" alt="Wishlist" class="icon">
            Cart
          </a>
        </li>
      </ul>
    </div>
  </nav>
<div class="row mt-3 text-center">
      <div class="col-3">
        <a href="topup.php">
          <div class="menu-item">
            <img src="https://img.icons8.com/ios-filled/50/000000/money-transfer.png" alt="Top Up">
            <p>Top Up</p>
          </div>
        </a>
      </div>
      <div class="col-3">
        <a href="isitoken.php">
          <div class="menu-item">
            <img src="https://img.icons8.com/ios-filled/50/000000/electrical.png" alt="Isi Token Listrik">
            <p>Isi Token</p>
          </div>
        </a>
      </div>
      <div class="col-3">
        <a href="bayartagihan.php">
          <div class="menu-item">
            <img src="https://img.icons8.com/ios-filled/50/000000/bill.png" alt="Bayar Tagihan">
            <p>Bayar Tagihan</p>
          </div>
        </a>
      </div>
      <div class="col-3">
        <a href="belanja.php">
          <div class="menu-item">
            <img src="https://img.icons8.com/ios-filled/50/000000/shopping-bag.png" alt="Belanja Online">
            <p>Belanja</p>
          </div>
        </a>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <h2>Produk yang Dijual</h2>
      </div>
      <?php if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <div class="col-12 col-md-3 mb-4">
            <div class="card">
              <img src="<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?php echo $row['nama_produk']; ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo $row['nama_produk']; ?></h5>
                <p class="card-text">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productModal"
                        data-id="<?php echo $row['id_produk']; ?>"
                        data-name="<?php echo $row['nama_produk']; ?>"
                        data-description="<?php echo $row['desk']; ?>"
                        data-price="<?php echo $row['harga']; ?>"
                        data-image="<?php echo $row['gambar']; ?>">
                  Beli Sekarang
                </button>
                <a href="add_to_cart.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn btn-secondary mt-2">
                  <img src="https://img.icons8.com/ios-filled/24/000000/shopping-cart.png" alt="Add to Cart"> Add to Cart
                </a>
              </div>
            </div>
          </div>
        <?php }
      } else { ?>
        <div class="col-12">
          <p class="text-center">Produk Tidak Ditemukan</p>
        </div>
      <?php } ?>
    </div>
  </div>


  <nav class="navbar fixed-bottom navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-around">
      <a class="nav-link text-center" href="index.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/home.png" alt="Home" class="icon">
        <span class="d-block">Home</span>
      </a>
      <a class="nav-link text-center" href="datatransaksi.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/transaction-list.png" alt="Data Transaksi" class="icon">
        <span class="d-block">Transaksi</span>
      </a>
      <a class="nav-link text-center" href="notification.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/appointment-reminders.png" alt="Notification" class="icon">
        <span class="d-block">Notif</span>
      </a>
      <a class="nav-link text-center" href="profile.php">
        <img src="https://img.icons8.com/ios-filled/50/000000/user.png" alt="Profile" class="icon">
        <span class="d-block">Profile</span>
      </a>
    </div>
  </nav>

  <!-- Modal -->
  <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productModalLabel">Detail Produk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img id="productImage" src="" class="img-fluid mb-3" alt="Product Image">
          <h5 id="productTitle"></h5>
          <p id="productDescription"></p>
          <p><strong id="productPrice"></strong></p>
          <form id="purchaseForm" method="post" action="process_transaction.php">
            <input type="hidden" id="productId" name="id_produk">
            <input type="hidden" id="productPriceHidden" name="harga_total">
            <div class="form-group">
              <label for="qty">Jumlah:</label>
              <input type="number" class="form-control" id="qty" name="qty" min="1" required>
            </div>
            <div class="form-group">
              <label for="metode_pembayaran">Metode Pembayaran:</label>
              <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="Kartu Kredit">Kartu Kredit</option>
                <option value="PayPal">PayPal</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $('#productModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Tombol yang mengaktifkan modal
      var id = button.data('id'); // Ambil data ID dari tombol
      var name = button.data('name'); // Ambil data nama produk
      var description = button.data('description'); // Ambil data deskripsi produk
      var price = button.data('price'); // Ambil data harga produk
      var image = button.data('image'); // Ambil data gambar produk
      
      var modal = $(this);
      modal.find('#productTitle').text(name);
      modal.find('#productDescription').text(description);
      modal.find('#productPrice').text('Rp ' + price.toLocaleString());
      modal.find('#productImage').attr('src', image);
      modal.find('#productId').val(id);
      modal.find('#productPriceHidden').val(price);
    });
  </script>
</body>
</html>
