<?php
// file: post.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Upload file gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = "uploads/" . $imageName;

        if (move_uploaded_file($imageTmpName, $imagePath)) {
            // Simpan data ke database
            $query = "INSERT INTO posts (title, description, image_path) VALUES ('$title', '$description', '$imagePath')";
            if (mysqli_query($conn, $query)) {
                $successMessage = "Post berhasil disimpan.";
            } else {
                $errorMessage = "Terjadi kesalahan saat menyimpan data.";
            }
        } else {
            $errorMessage = "Gagal mengupload gambar.";
        }
    } else {
        $errorMessage = "Harap pilih gambar untuk diupload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Konten - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="css/post.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <h1>SMK HIJAU MUDA</h1>
        </div>
        <ul class="nav-menu">
            <li><a href="admin_dashboard.php">Beranda</a></li>
            <li><a href="post.php">Post</a></li>
            <li><a href="data_pendaftar_admin.php">Data Calon Siswa</a></li>
            <li><a href="data_pembayaran.php">Data Pembayaran</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Tambah Postingan Baru</h2>
    <?php if (isset($successMessage)) { echo "<p class='success'>$successMessage</p>"; } ?>
    <?php if (isset($errorMessage)) { echo "<p class='error'>$errorMessage</p>"; } ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Gambar</label>
            <input type="file" name="image" id="image" accept="image/*" required>
        </div>
        <button type="submit">Simpan Post</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 PPDB SMK HIJAU MUDA. All Rights Reserved.</p>
</footer>
</body>
</html>
