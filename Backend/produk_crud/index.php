<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

require 'functions.php';
$tb_produk = mysqli_query($conn, "SELECT * FROM tb_produk");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk CRUD</title>
</head>

<body>
    <a href="logout.php">Logout</a>
    <h1>Daftar Produk</h1>
    <a href="tambah.php">Tambah Data Produk</a> <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead align="center">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga HPP</th>
                <th>Harga Retail</th>
                <th>Harga Distributor</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody align="center">
            <?php $i = 1; ?>
            <?php foreach ($tb_produk as $row): ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?php echo $row['kd_barang']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td><?php echo $row['harga_hpp']; ?></td>
                <td><?php echo $row['harga_retail']; ?></td>
                <td><?php echo $row['harga_distributor']; ?></td>
                <td><img src="img/<?php echo $row['gambar']; ?>" width="50"></td>
                <td>
                    <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a>
                    <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>