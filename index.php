<?php
session_start();

if (!isset($_SESSION['user'])) header("location: ./login.php");

require_once "./db.php";

$all_data = [];
$all_stocks = 0;
$warning_stock = [];
$opname = [
  "in" => 0,
  "out" => 0
];

$result = $conn->query("SELECT * FROM barang ORDER BY nama");

while ($data = $result->fetch_assoc()) {
  $all_data[] = $data;
}

// ambil total stok
$result = $conn->query("SELECT SUM(stok) FROM barang");

$all_stocks = + ($result->fetch_assoc()["SUM(stok)"] ?? 0);

// ambil barang dengan stok di bawah 10
$result = $conn->query("SELECT * FROM barang WHERE stok <= 10 ORDER BY stok LIMIT 1");

$warning_stock = $result->fetch_assoc();

// ambil transaksi masuk dan keluar
$stmt = $conn->prepare("SELECT * FROM transaksi WHERE tanggal=?");

$tanggal = date("Y-m-d");

$stmt->bind_param("s", $tanggal);

$stmt->execute();

$result = $stmt->get_result();

while ($data = $result->fetch_assoc()) {
  $opname[$data['kategori']] += $data['jumlah'];
}

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
          <a class="nav-link active" aria-current="page" href="./index.php">Beranda</a>
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

  <div class="container mb-4">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <p class="text-center fs-1 text-primary">
              <?= $all_stocks ?>
            </p>
            <h5 class="card-title text-center">Total stok barang</h5>
            <div class="d-flex justify-content-center">
              <small class="text-center">Semua barang</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <?php if ($warning_stock !== null): ?>
              <p class="text-center fs-1 text-warning">
                <?= $warning_stock['nama'] ?>
              </p>
              <h5 class="card-title text-center">Barang hampir habis</h5>
              <div class="d-flex justify-content-center">
                <small class="text-center">Stok sisa
                  <span class="text-danger">
                    <?= $warning_stock['stok'] ?>
                  </span>
                </small>
              </div>
            <?php else: ?>
              <p class="text-center fs-1 text-success">Tidak ada</p>
              <h5 class="card-title text-center">Barang hampir habis</h5>
              <div class="d-flex justify-content-center">
                <small class="text-center">Stok aman
                </small>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <p class="text-center fs-1">
              <span class="text-success">
                <?= $opname['in'] ?>
              </span>
              /
              <span class="text-danger">
                <?= $opname['out'] ?>
              </span>
            </p>
            <h5 class="card-title text-center">Barang masuk/keluar</h5>
            <div class="d-flex justify-content-center">
              <small class="text-center">Hari ini</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h1 class="mb-3">Daftar Barang</h1>

      <a href="./insert.php" class="btn btn-primary">
        Tambah barang
      </a>
    </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">Stok</th>
              <th scope="col">Harga</th>
              <th scope="col">Kategori</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($all_data) !== 0): ?>
              <?php foreach ($all_data as $i => $data): ?>
                <tr>
                  <th scope="row"><?= $i + 1 ?></th>
                  <td>
                    <?= $data['kode'] ?>
                  </td>
                  <td>
                    <?= $data['nama'] ?>
                  </td>
                  <td>
                    <?= $data['stok'] ?>
                  </td>
                  <td>
                    Rp. <?= $data['harga'] ?>
                  </td>
                  <td>
                    <?= $data['kategori'] ?>
                  </td>
                  <td style="width: 150px;">
                    <div class="dropdown">
                      <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Detail
                      </a>

                      <ul class="dropdown-menu">
                        <li>
                          <a href="./edit.php?kode=<?= $data['kode'] ?>" class="dropdown-item">Edit</a>
                        </li>

                        <li>
                          <a href="./opname.php?kode=<?= $data['kode'] ?>" class="dropdown-item">Opname</a>
                        </li>

                        <li>
                          <form action="./delete.php?kode=<?= $data['kode'] ?>" method="post" onsubmit="return confirm('yakin?')">
                            <button type="submit" class="dropdown-item text-danger">Hapus</button>
                          </form>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <td colspan="8">
                <p class="text-center">Data barang kosong</p>
              </td>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>