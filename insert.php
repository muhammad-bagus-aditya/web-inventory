<?php
session_start();

if (!isset($_SESSION['user'])) header("location: ./login.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Stok Inventaris</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar navbar-dark bg-primary navbar-expand-lg mb-4">
    <div class="container py-2">
      <a class="navbar-brand" href="#">Kang Tresno Inventory</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="./index.php">Beranda</a>
          <a class="nav-link" href="./index.php">Laporan</a>
          <form action="./logout.php" method="post" class="d-lg-none" onsubmit="return confirm('Apakah anda ingin logout?')">
            <button class="nav-link" type="submit">
              Logout
            </button>
          </form>
        </div>

        <div class="navbar-nav ms-auto d-none d-lg-flex">
          <div class="dropdown">
            <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['user']['email'] ?>
            </a>

            <ul class="dropdown-menu">
              <li>
                <form action="./logout.php" method="post" onsubmit="return confirm('Apakah anda ingin logout?')">
                  <button class="dropdown-item" type="submit">
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h1 class="mb-3">Tambah Barang</h1>
    </div>

    <div class="card">
      <div class="card-body">
        <form action="./insert-post.php" method="post">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="kode" class="form-label">Kode barang</label>
              <input type="text" id="kode" name="kode" class="form-control" placeholder="Isi kode barang di sini" />
            </div>

            <div class="col-md-4 mb-3">
              <label for="nama" class="form-label">Nama barang</label>
              <input type="text" id="nama" name="nama" class="form-control" placeholder="Isi nama barang di sini" />
            </div>

            <div class="col-md-4 mb-3">
              <label for="stok" class="form-label">Stok barang</label>
              <input type="text" id="stok" name="stok" class="form-control" placeholder="Isi stok barang di sini" />
            </div>

            <div class="col-md-4 mb-3">
              <label for="harga" class="form-label">Harga barang</label>
              <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="number" id="harga" name="harga" class="form-control" placeholder="Isi harga barang di sini" />
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <label for="kategori" class="form-label">Kategori barang</label>
              <input type="text" id="kategori" name="kategori" class="form-control" placeholder="Isi kategori barang di sini" />
            </div>
          </div>

          <div class="d-flex">
            <button type="submit" class="btn btn-primary ms-auto">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>