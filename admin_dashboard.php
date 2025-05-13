<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

$admin_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';

// Koneksi ke database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli('localhost', 'ppdb7395_smkhm', 'SdfaCOLq6[Tl', 'ppdb7395_smk_hijau_muda');

// Ambil kuota terbaru
$result = mysqli_query($conn, "SELECT * FROM kuota_ppdb LIMIT 1");
$data_kuota = mysqli_fetch_assoc($result);

// Proses tambah kuota baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kuota']) && isset($_POST['tahun'])) {
    $kuota = intval($_POST['kuota']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);

    // Cek apakah tahun ajaran sudah ada
    $check = mysqli_query($conn, "SELECT * FROM kuota_ppdb WHERE tahun_ajaran = '$tahun'");
    if (mysqli_num_rows($check) > 0) {
        $update = "UPDATE kuota_ppdb SET kuota = '$kuota' WHERE tahun_ajaran = '$tahun'";
        mysqli_query($conn, $update);
    } else {
        $insert = "INSERT INTO kuota_ppdb (kuota, tahun_ajaran) VALUES ('$kuota', '$tahun')";
        mysqli_query($conn, $insert);
    }
    header("Location: admin_dashboard.php");
    exit();
}

// Proses edit kuota
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan_perubahan'])) {
    $tahun_lama = $_POST['tahun_lama'];
    $kuota_baru = $_POST['edit_kuota'];
    $tahun_baru = $_POST['edit_tahun'];

    $query = "UPDATE kuota_ppdb SET kuota = '$kuota_baru', tahun_ajaran = '$tahun_baru' WHERE tahun_ajaran = '$tahun_lama'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Gagal mengupdate kuota: " . mysqli_error($conn);
    }
}

// Hapus kuota
if (isset($_GET['delete_kuota'])) {
    $delete = mysqli_query($conn, "DELETE FROM kuota_ppdb");
    if ($delete) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Gagal menghapus kuota: " . mysqli_error($conn);
    }
}

// Hitung total pendaftar
$result_pendaftar = mysqli_query($conn, "SELECT COUNT(*) AS total_pendaftar FROM pendaftar");
$data_pendaftar = mysqli_fetch_assoc($result_pendaftar);
$total_pendaftar = $data_pendaftar['total_pendaftar'];

// Hitung sisa kuota
$sisa_kuota = isset($data_kuota['kuota']) ? $data_kuota['kuota'] - $total_pendaftar : 0;


// Simpan data jika form disubmit untuk infoppdb
if (isset($_POST['simpan'])) {
    $jenis = $_POST['jenis'];
    $nominal = $_POST['nominal'];

    mysqli_query($conn, "INSERT INTO informasi_ppdb (jenis, nominal) VALUES ('$jenis', '$nominal')");
}

// Ambil semua datainfo ppdb
$data_ppdb = mysqli_query($conn, "SELECT * FROM informasi_ppdb");

if (isset($_GET['hapus_informasi']) && $_GET['hapus_informasi'] == 'true') {
    $hapus = mysqli_query($conn, "DELETE FROM informasi_ppdb");

    if ($hapus) {
        echo "<script>alert('Semua data informasi PPDB berhasil dihapus.'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }
}

// set gelombang
if (isset($_POST['simpan_gelombang'])) {
    $gelombang = $_POST['gelombang'];
    $tanggal = $_POST['tanggal'];
    $kuota = $_POST['kuota'];

    $query = mysqli_query($conn, "INSERT INTO gelombang_ppdb (gelombang, tanggal, kuota) VALUES ('$gelombang', '$tanggal', '$kuota')");

    if ($query) {
        echo "<script>alert('Gelombang berhasil disimpan!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data gelombang.');</script>";
    }
}

// Proses hapus data gelombang jika parameter 'hapus_informasi' ada
if (isset($_GET['hapus_informasi'])) {
    // Cek konfirmasi hapus (untuk menghindari penghapusan tanpa sengaja)
    $confirm = $_GET['hapus_informasi'];
    if ($confirm == 'true') {
        // Query untuk menghapus semua data gelombang
        $delete_query = "DELETE FROM gelombang_ppdb";
        $result = mysqli_query($conn, $delete_query);

        // Cek apakah query berhasil
        if ($result) {
            echo "<script>alert('Semua data gelombang berhasil dihapus.'); window.location='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data gelombang.'); window.location='admin_dashboard.php';</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <style>
        .kuota-box, .edit-form, .set-kuota-form {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        button{
            margin-top: 10px;
            padding: 8px 12px;
            background:rgb(16, 115, 79);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;

        }
        .set-kuota-form {
        max-width: 500px;
        margin: 40px auto;
        background: linear-gradient(135deg, #e0f7fa,rgb(30, 119, 73));
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.6s ease-in-out;
        font-family: 'Segoe UI', sans-serif;
    }

    .set-kuota-form h3 {
        text-align: center;
        margin-bottom: 20px;
        color:rgb(15, 111, 63);
        font-size: 24px;
    }

    .set-kuota-form label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
    }

    .set-kuota-form input[type="number"],
    .set-kuota-form input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 2px;
        border-radius: 8px;
        margin-bottom: 20px;
        transition: border 0.3s ease;
        font-size: 16px;
    }

    .set-kuota-form input:focus {
        border-color: #00796b;
        outline: none;
    }

    .set-kuota-form button {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        background-color: #00796b;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-right: 10px;
    }

    .set-kuota-form button:hover {
        background-color:rgb(18, 84, 41);
    }

    .set-kuota-form a button {
        background-color:rgb(32, 118, 105);
    }

    .set-kuota-form a button:hover {
        background-color:rgb(53, 121, 70);
    }

    /* Animasi fadeIn */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

        .edit-form button{
            margin-top: 10px;
            padding: 8px 12px;
            background:rgb(29, 120, 59);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
            font-size: 28px;
            margin-top: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        /* Tombol Navigasi */
        a button {
            margin: 10px 5px;
            padding: 10px 20px;
            background-color:rgb(34, 115, 73);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        a button:hover {
            background-color:rgb(45, 146, 84);
            transform: scale(1.05);
        }

        /* Info Section */
        .info-section {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .info-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            padding: 25px;
            background:rgb(188, 196, 179);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 90%;
            animation: fadeInUp 1s ease;
        }

        .info-box div {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            flex: 1 1 200px;
            text-align: center;
        }

        .info-box p {
            margin: 5px 0;
            font-size: 16px;
        }

        .info-box strong {
            color: #33691e;
            font-weight: bold;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }


        table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-family: Arial, sans-serif;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* css edit kuota */
        .edit-form {
        max-width: 500px;
        margin: 50px auto;
        padding: 30px 40px;
        background: linear-gradient(135deg, #e0f7fa, #ffffff);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.8s ease-in-out;
    }

    .edit-form h3 {
        text-align: center;
        color:rgb(37, 141, 107);
        margin-bottom: 25px;
    }

    .edit-form label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
        color: #004d40;
    }

    .edit-form input[type="number"],
    .edit-form input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 2px solid #b2dfdb;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .edit-form input:focus {
        outline: none;
        border-color:rgb(33, 150, 109);
        background-color: #e0f2f1;
    }

    .edit-form button {
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        margin: 5px 3px;
        background-color: rgb(33, 150, 109);
        color: white;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .edit-form button:hover {
        background-color:rgb(33, 150, 109);
        transform: scale(1.05);
    }

    .edit-form a button {
        background-color: #ff7043;
    }

    .edit-form a button:hover {
        background-color: #d84315;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Styling untuk tombol kembali */
    button {
        background-color:rgb(33, 150, 109);
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        border-radius: 5px;
    }

    button:hover {
        background-color: rgb(28, 219, 152);
    }

    /* Styling untuk heading */
    h3 {
        font-family: Arial, sans-serif;
        font-size: 24px;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    /* informasi kuota */
    .kuota-box {
    max-width: 500px;
    margin: 30px auto;
    padding: 25px 35px;
    background: linear-gradient(135deg, #f1f8e9, #ffffff);
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    text-align: center;
    animation: fadeIn 0.8s ease-in-out;
    }

    .kuota-box h4 {
        color: #33691e;
        font-size: 20px;
        margin-bottom: 15px;
    }

    .kuota-box p {
        color: rgb(33, 150, 109);
        font-size: 16px;
        margin-bottom: 20px;
    }

    .kuota-box button {
        padding: 10px 20px;
        background-color: rgb(33, 150, 109);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .kuota-box button:hover {
        background-color: rgb(33, 150, 109);
        transform: scale(1.05);
    }

    /* Gunakan animasi fadeIn yang sudah didefinisikan sebelumnya */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* informasi ppdb */
    .informasi-ppdb-form {
    background-color:rgb(210, 232, 221);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    width: 50%;
    margin: 0 auto;
    animation: slideIn 1s ease-out;
    margin-top: 50px;
}

.informasi-ppdb-form h3 {
    text-align: center;
    color: #333;
    font-size: 28px;
    margin-bottom: 30px;
}

.informasi-ppdb-form label {
    font-weight: bold;
    font-size: 16px;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

.informasi-ppdb-form input[type="text"], 
.informasi-ppdb-form input[type="number"] {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 2px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

.informasi-ppdb-form input[type="text"]:focus,
.informasi-ppdb-form input[type="number"]:focus {
    border-color:rgb(33, 150, 109);
    outline: none;
}

.form-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.informasi-ppdb-form button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 14px 24px;
    font-size: 18px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 48%;
}

.informasi-ppdb-form button:hover {
    background-color: #45a049;
}

.kembali-btn {
    background-color: #f44336;
    width: 48%;
}

.kembali-btn:hover {
    background-color: #d32f2f;
}

@keyframes slideIn {
    0% {
        opacity: 0;
        transform: translateX(-100px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

/* CSS form Set Gelombang */
.form-gelombang-container {
    background: linear-gradient(to right, #f8f9fa,rgb(14, 143, 83));
    max-width: 500px;
    margin: 30px auto;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    animation: fadeIn 0.7s ease-in-out;
}

.form-gelombang-container h3 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.form-gelombang-container label {
    font-weight: bold;
    color: #444;
    display: block;
    margin-bottom: 5px;
}

.form-gelombang-container input[type="text"],
.form-gelombang-container input[type="date"],
.form-gelombang-container input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 15px;
    transition: border 0.3s;
}

.form-gelombang-container input:focus {
    border-color:rgb(21, 147, 105);
    outline: none;
}

.form-gelombang-container button {
    width: 100%;
    padding: 12px;
    background-color:rgb(27, 155, 87);
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.form-gelombang-container button:hover {
    background-color: rgb(62, 171, 113);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


    </style>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <h1>SMK HIJAU MUDA</h1>
        </div>
        <ul class="nav-menu">
            <li><a href="admin_dashboard.php">Beranda</a></li>
            <li><a href="data_pendaftar_admin.php">Data Calon Siswa</a></li>
            <li><a href="data_pembayaran.php">Data Pembayaran</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Welcome <?php echo $admin_name; ?>!</h2>

    <?php if (!isset($_GET['set_gelombang']) && !isset($_GET['set_kuota']) && !isset($_GET['edit']) && !isset($_GET['informasi_ppdb'])): ?>
        <!-- Tampilan utama hanya jika tidak ada parameter set_kuota, informasi_ppdb, atau edit -->
        <a href="?set_kuota=true"><button>Set Kuota</button></a>
        <a href="?informasi_ppdb=true"><button>Set Biaya PPDB</button></a>
        <a href="?set_gelombang=true"><button>Set Gelombang</button></a>
        
        <div class="info-section">
            <div class="info-box">
                <div>
                    <p><strong>Total Pendaftar:</strong></p>
                    <p><?php echo $total_pendaftar; ?> orang</p>
                </div>
                <div>
                    <p><strong>Sisa Kuota:</strong></p>
                    <p><?php echo $sisa_kuota; ?> orang</p>
                </div>
                <div class="clock">
                    <p><strong>Jam Sekarang:</strong></p>
                    <p id="current-time"></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Kuota -->
    <?php if (isset($_GET['set_kuota'])): ?>
        <div class="set-kuota-form">
            <h3>Set Kuota PPDB</h3>
            <form action="admin_dashboard.php" method="POST">
                <label for="kuota">Jumlah Kuota:</label>
                <input type="number" name="kuota" id="kuota" required>

                <label for="tahun">Tahun Ajaran:</label>
                <input type="text" name="tahun" id="tahun" placeholder="Contoh: 2025/2026" required>

                <button type="submit">Simpan Kuota</button>
                <a href="admin_dashboard.php"><button type="button">Kembali</button></a>
            </form>
        </div>
    <?php endif; ?>

    <!-- Form Edit Kuota -->
    <?php if (isset($_GET['edit']) && $data_kuota): ?>
        <div class="edit-form">
            <h3>Edit Kuota PPDB</h3>
            <form action="admin_dashboard.php" method="POST">
                <input type="hidden" name="tahun_lama" value="<?php echo $data_kuota['tahun_ajaran']; ?>">

                <label for="edit_kuota">Jumlah Kuota:</label>
                <input type="number" name="edit_kuota" id="edit_kuota" value="<?php echo $data_kuota['kuota']; ?>" required>

                <label for="edit_tahun">Tahun Ajaran:</label>
                <input type="text" name="edit_tahun" id="edit_tahun" value="<?php echo $data_kuota['tahun_ajaran']; ?>" required>

                <button type="submit" name="simpan_perubahan">Simpan Perubahan</button>
                <a href="?delete_kuota=true" onclick="return confirm('Yakin ingin menghapus kuota ini?');">
                    <button type="button" style="background-color: red;">Hapus</button>
                </a>
                <a href="admin_dashboard.php"><button type="button">Kembali</button></a>
            </form>
        </div>
    <?php endif; ?>

    <!-- Form Informasi PPDB -->
    <?php if (isset($_GET['informasi_ppdb'])): ?>
    <div class="informasi-ppdb-form">
        <h3>Form Tambah Biaya PPDB</h3>
        <form method="POST">
            <label for="nomor">Nomor:</label><br>
            <input type="text" name="nomor" id="nomor" required><br><br>

            <label for="jenis">Jenis:</label><br>
            <input type="text" name="jenis" id="jenis" required><br><br>

            <label for="nominal">Nominal (Rp):</label><br>
            <input type="number" name="nominal" id="nominal" required><br><br>

            <button type="submit" name="simpan">Simpan</button>
            <a href="admin_dashboard.php"><button type="button">Kembali</button></a>
        </form>
    </div>
<?php endif; ?>


    <!-- Tampilan Kuota Terbaru, hanya muncul jika tidak ada parameter set_kuota atau edit -->
    <?php if (!isset($_GET['set_gelombang']) && !isset($_GET['set_kuota']) && !isset($_GET['edit']) && !isset($_GET['informasi_ppdb'])): ?>
        <div class="kuota-box">
            <h4>Kuota PPDB Tahun Ajaran <?php echo $data_kuota['tahun_ajaran']; ?></h4>
            <p>Jumlah Kuota: <strong><?php echo $data_kuota['kuota']; ?></strong> siswa</p>
            <a href="?edit=true"><button>Edit Kuota</button></a>
        </div>
    <?php endif; ?>

    <br>

    <!-- Daftar Informasi PPDB, hanya tampil jika tidak ada parameter set_kuota atau informasi_ppdb -->
    <?php if (!isset($_GET['set_gelombang']) && !isset($_GET['set_kuota']) && !isset($_GET['edit']) && !isset($_GET['informasi_ppdb'])): ?>
        <h3>Daftar Biaya PPDB</h3>
        <table border="1" cellpadding="8" cellspacing="0">
        <a href="admin_dashboard.php?hapus_informasi=true" onclick="return confirm('Yakin ingin menghapus semua data informasi PPDB?');">
            <button style="background-color:red;color:white;">Hapus Semua Data Biaya</button>
        </a>
            <tr>
                <th>NO</th>
                <th>Jenis</th>
                <th>Nominal</th>
            </tr>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($data_ppdb)) {
                echo "<tr>
                        <td>$no</td>
                        <td>{$row['jenis']}</td>
                        <td>Rp " . number_format($row['nominal'], 0, ',', '.') . "</td>
                    </tr>";
                $no++;
            }
            ?>
        </table>
        <?php endif; ?>

        <!-- set gelombang -->

        <?php if (isset($_GET['set_gelombang'])): ?>
    <div class="form-gelombang-container">
        <h3>Form Set Gelombang</h3>
        <form action="admin_dashboard.php" method="POST">
            <label>Gelombang:</label>
            <input type="text" name="gelombang" required>
            
            <label>Tanggal:</label>
            <input type="date" name="tanggal" required>
            
            <label>Kuota:</label>
            <input type="number" name="kuota" required>
            
            <button type="submit" name="simpan_gelombang">Simpan</button>
        </form>
    </div>
<?php endif; ?>

    <!-- tampilan set gelombang -->
    <?php if (!isset($_GET['set_gelombang']) && !isset($_GET['set_kuota']) && !isset($_GET['edit']) && !isset($_GET['informasi_ppdb'])): ?>
    <h3>Data Gelombang PPDB</h3>
    <a href="admin_dashboard.php?hapus_informasi=true" onclick="return confirm('Yakin ingin menghapus semua data informasi PPDB?');">
            <button style="background-color:red;color:white;">Hapus Semua Data Biaya</button>
        </a>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Gelombang</th>
            <th>Tanggal</th>
            <th>Kuota</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM gelombang_ppdb");
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['gelombang']}</td>
                    <td>{$row['tanggal']}</td>
                    <td>{$row['kuota']}</td>
                </tr>";
            $no++;
        }
        ?>
    </table>
<?php endif; ?>

</div>

<footer>
    <p>&copy; 2025 PPDB SMK HIJAU MUDA. All Rights Reserved.</p>
</footer>


<script>
function updateClock() {
    const currentTimeElement = document.getElementById("current-time");
    const currentDate = new Date();
    let hours = currentDate.getHours();
    let minutes = currentDate.getMinutes();
    let seconds = currentDate.getSeconds();

    if (minutes < 10) minutes = '0' + minutes;
    if (seconds < 10) seconds = '0' + seconds;

    currentTimeElement.textContent = `${hours}:${minutes}:${seconds}`;
}
setInterval(updateClock, 1000);
updateClock();
</script>
</body>
</html>
