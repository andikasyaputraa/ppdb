<?php
// Koneksi ke database
include 'includes/db.php';

// Kuota maksimal
$max_kuota = 500;

// Ambil jumlah pendaftar
$query = "SELECT COUNT(*) AS total_pendaftar FROM pendaftar";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_pendaftar = $row['total_pendaftar'];
$sisa_kuota = $max_kuota - $total_pendaftar;

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
// Query untuk mengambil data gelombang
$query = "SELECT * FROM gelombang_ppdb";  // Ambil semua data dari tabel gelombang_ppdb
$result = mysqli_query($conn, $query);   // Eksekusi query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/index.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <style>
        /* Style tombol */
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

        .btn {
            display: inline-block;
            background-color: #3e9565;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            margin-top: 2px;
            width:50%px;
        }
        .btn:hover {
            background-color:rgb(134, 217, 172);
        }
         .btn1 {
            display: inline-block;
            background-color: rgb(51, 149, 152);
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 50px;
            margin-top: 2px;
            width:50%px;
        }
        .btn1:hover {
            background-color:rgb(8, 70, 72);
        }
        .btn2 {
            display: inline-block;
            background-color: rgb(229, 197, 15);
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 50px;
            margin-top: 2px;
            width:50%px;
        }
        .btn2:hover {
            background-color:rgb(157, 134, 6);
        }
        .btn3 {
            display: inline-block;
            background-color: rgb(39, 93, 121);
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 50px;
            margin-top: 2px;
            width:50%px;
        }
        .btn3:hover {
            background-color:rgb(90, 146, 175);
        }
        
        /* Pusatkan tombol */
        .center-button {
            text-align: center;
            margin-top: 10px;
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
    </header>

    <section id="home">
        <div class="hero">
        <div class="slideshow-container">
                <div class="navbar">
            </div>
            <div class="mySlides fade">
                <img src="img1.JPG" style="width:100%"> 
            </div>
            <div class="mySlides fade">
                <img src="img8.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
                <img src="img2.JPG" style="width:100%">
            </div>
            <div class="mySlides fade">
                <img src="img13.JPG" style="width:100%">
            </div>
            <div class="mySlides fade">
                <img src="img3.JPG" style="width:100%">
            </div>
            <div class="mySlides fade">
                <img src="img4.JPG" style="width:100%"> 
            </div>
            <div class="mySlides fade">
                <img src="pencaksilat.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
                <img src="img9.JPG" style="width:100%">
            </div>
            <br>
            <br>
           <div class="slideshow-text">
            <h2>Selamat Datang di PPDB SMK Hijau Muda</h2>
            <p>Mari bersinergi dan raih prestasi bersama SMK Hijau Muda</p>
            <br>
            <div class="btn-container">
                <a href="register.php" class="btn">Daftar Sekarang</a>
                <a href="login.php" class="btn btn-secondary">Masuk</a>
            </div>
        </div>
    </section>
    
   <div class="sekolah">
    <div class="info">
        <h1>Seputar SMK Hijau Muda</h1>
        <p id="seputar-smk">
            Sekolah Menengah Kejuruan Pusat Keunggulan Hijau Muda adalah lembaga pendidikan yang berperan aktif 
            dalam mencetak generasi bangsa yang berkarakter, nasionalisme, berakhlak mulia, serta siap 
            bersaing pada dunia profesional.
        </p>

        <h2>Visi SMK Hijau Muda</h2>
        <p>
            Terciptanya insan yang unggul, berprestasi, dan terampil dalam bekerja dengan dilandasi Iman dan Taqwa.
        </p>

        <h2>Misi SMK Hijau Muda</h2>
        <ul>
            <li>Meningkatkan kualitas pendidikan.</li>
            <li>Meningkatkan kualitas sumber daya manusia agar selalu siap menghadapi tantangan di era globalisasi.</li>
            <li>
                Meningkatkan keimanan dan ketaqwaan sebagai landasan moral untuk mampu bersaing di era pasar kerja global.
            </li>
        </ul>
    </div>
</div>
    <br>
    <!-- Informasi PPDB -->
    <?php if (!isset($_GET['set_gelombang']) && !isset($_GET['set_kuota']) && !isset($_GET['edit']) && !isset($_GET['informasi_ppdb'])): ?>
    <h3 style="text-align: center;">Data Gelombang PPDB</h3>
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
<br>
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
    <script>
        // Fungsi untuk memperbarui waktu real-time
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }

        // Jalankan fungsi setiap 1 detik
        setInterval(updateClock, 1000);

        // Panggil fungsi pertama kali saat halaman dimuat
        updateClock();
    </script>
<br>
<section id="informasi-ppdb" style="margin: 50px 20px;">
<h3>Daftar Biaya PPDB</h3>
        <table border="1" cellpadding="8" cellspacing="0">
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

    <br>
    
    <div class="jurusan">
        <h2 style="text-align: Center; color:black;" >Jurusan Prodi SMK Hijau Muda</h2>
    <div class="center-button">
        <a href="tkr.php" class="btn1">TEKNIK KENDARAAN RINGAN</a>
        <a href="tkj.php" class="btn2">TEKNIK KOMPUTER JARINGAN TELEKOMUNIKASI</a>
        <a href="mp.php" class="btn3">MANAJEMEN PERKANTORAN</a>

    </div>
    </div>
    <br>
    <h1 style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:25px;
    text-align:center">
    <br>
    <div class="maps">
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0073753555353!2d107.17473317499078!3d-6.262757693725862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6984969a6ece51%3A0x4048cc171ffdb3e0!2sSMK%20Hijau%20Muda!5e0!3m2!1sid!2sid!4v1730478647052!5m2!1sid!2sid" 
        width="100%" height="200" 
        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <br>
    <footer>
        <p>&copy; 2025 PPDB SMK HIJAU MUDA. All Rights Reserved.</p>
    </footer>
    <br>

    <script>
let slideIndex = 0;
showSlides();

// Fungsi untuk menampilkan slideshow
function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; // Sembunyikan semua slide
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 } // Jika slideIndex lebih dari jumlah slide, reset ke 1
    slides[slideIndex - 1].style.display = "block"; // Tampilkan slide yang sesuai
    setTimeout(showSlides, 4000); // Ganti slide setiap 4 detik
}

// Fungsi untuk navigasi slide
function plusSlides(n) {
    slideIndex += n;
    if (slideIndex > slides.length) { slideIndex = 1 }
    if (slideIndex < 1) { slideIndex = slides.length }
    showSlidesManually(slideIndex);
}

// Fungsi untuk menampilkan slide secara manual
function showSlidesManually(index) {
    let slides = document.getElementsByClassName("mySlides");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; // Sembunyikan semua slide
    }
    slides[index - 1].style.display = "block"; // Tampilkan slide yang sesuai
}

// untuk info 
document.addEventListener("DOMContentLoaded", function() {
    const infoElement = document.querySelector('.info');

    function handleScroll() {
        const infoPosition = infoElement.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.2;

        if (infoPosition < screenPosition) {
            infoElement.classList.add('show');
            window.removeEventListener('scroll', handleScroll); // Animasi hanya terjadi sekali
        }
    }

    window.addEventListener('scroll', handleScroll);
});

// // Ambil data postingan
// $query = "SELECT * FROM posts ORDER BY created_at DESC";
// $result = mysqli_query($conn, $query);
// ?>

</script>

</body>
</html>
