<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "produk";

$conn = mysqli_connect($host, $username, $password, $database);

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function tambah($data) {
    global $conn;

    $kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $harga_hpp = htmlspecialchars($data["harga_hpp"]);
    $harga_retail = htmlspecialchars($data["harga_retail"]);
    $harga_distributor = htmlspecialchars($data["harga_distributor"]);
    
    // Upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // Query insert data
    $query = "INSERT INTO tb_produk VALUES ('', '$kode_barang', '$nama_barang', '$harga_hpp', '$harga_retail', '$harga_distributor', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES ['gambar']['error'];
    $tmpName = $_FILES ['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if($error === 4) {
        echo "<script>
        alert('Pilih gambar terlebih dahulu!');
        </script>";
        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
        alert('Yang anda upload bukan gambar!');
        </script>";
        return false;
    }

    // Cek jika ukurannya terlalu besar
    if ($ukuranFile > 5000000) {
        echo "<script>
        alert('Ukuran gambar terlalu besar!');
        </script>";
        return false;
    }

    // Lolos pengecekan, gambar siap diupload
    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus($id) {
    global $conn;

    // Ambil data produk berdasarkan id
    $query = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id='$id'");
    if (!$query) {
        return false;
    }

    $file = mysqli_fetch_assoc($query);
    if ($file) {
        $filePath = 'img/' . $file['gambar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Hapus data produk berdasarkan id
    $hapus = "DELETE FROM tb_produk WHERE id='$id'";
    mysqli_query($conn, $hapus);

    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $kode_barang = htmlspecialchars($data["kode_barang"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $harga_hpp = htmlspecialchars($data["harga_hpp"]);
    $harga_retail = htmlspecialchars($data["harga_retail"]);
    $harga_distributor = htmlspecialchars($data["harga_distributor"]);
    $gambar_lama = htmlspecialchars($data["gambar_lama"]);
    
    // Cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama;
    } else {
        $gambar = upload();
    }
    
    // Query insert data
    $query = "UPDATE tb_produk SET kd_barang = '$kode_barang', nama_barang = '$nama_barang', harga_hpp = '$harga_hpp', harga_retail = '$harga_retail', harga_distributor = '$harga_distributor', gambar = '$gambar' WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM pengguna WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username sudah terdaftar!');
        </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('Konfirmasi password tidak sesuai!');
        </script>";
        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO pengguna VALUES ('', '$username', '$password')");
    return mysqli_affected_rows($conn);
}
?>