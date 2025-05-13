<?php
session_start();
$id_user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; // Cek apakah session tersedia

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran PPDB</title>
    <link rel="stylesheet" href="css/formulir.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <h2>Formulir Pendaftaran PPDB 2025/2026</h2>
        <form id="ppdb-form" action="submit_form.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" id="user_id"  value="<?php echo htmlspecialchars($id_user); ?>">
            <!-- Gelombang -->
            <label for="gelombang">Gelombang:</label>
            <select id="gelombang" name="gelombang" required>
                <option value="">Pilih Gelombang</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="kip_anak_yatim">KIP</option>
            </select>
            <br>

            <label for="rekomendasi">Rekomendasi:</label>
            <input type="text" id="rekomendasi" name="rekomendasi" placeholder="Masukkan nama rekomendasi">
            <p style="color:tomato; font-size:15px">Masukkan nama Guru yang merekomendasikan Anda, lewati tahap ini jika tidak ada rekomendasi</p>
            <br>
             
          
            <label for="email" style=" margin-bottom: 5px; display: block;">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Masukkan email Anda"
                style="width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            <br>
        
            <label for="telp">Nomor Telepon:</label>
            <input type="text" id="telp" name="telp" required placeholder="Masukkan nomor telepon Anda">
            <br>
            <br>

            
            <h3>Data Pribadi</h3>
            <br>
            <div style="width: 100%; max-width: 100%; margin: 0 auto;">
            <!-- foto -->
            <label for="foto" class="form-label">Upload Foto:</label>
            <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
            <img id="previewFoto" src="#" alt="Preview Foto" style="display:none; width: 100px; margin-top: 10px;">
            <br>

            <!-- Nama Lengkap -->
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama Lengkap">

            <!-- nik -->
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="nik" required placeholder="Masukkan Nik anda">

            <!-- Tempat Tanggal Lahir -->
            <label for="tempat_lahir">Tempat Lahir:</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" required placeholder="Masukkan Tempat Lahir">

            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required placeholder="mm/dd/yyy">

            <!-- Jenis Kelamin -->
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <!-- Alamat -->
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" required placeholder="Masukkan Alamat">

            <!-- Agama -->
            <label for="agama">Agama:</label>
            <select id="agama" name="agama" required>
                <option value="">Pilih Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Konghucu">Konghucu</option>
                <option value="Hindu">Hindu</option>
                <option value="Budha">Budha</option>
            </select>

            <!-- Anak Ke- -->
            <label for="anak_ke">Anak Ke-:</label>
            <input type="number" id="anak_ke" name="anak_ke" min="1" required placeholder="Anak ke-">

            <!-- Jumlah Saudara -->
            <label for="jumlah_saudara">Jumlah Saudara:</label>
            <input type="number" id="jumlah_saudara" name="jumlah_saudara" min="0" required placeholder="Jumlah Saudara">

            <!-- Status Dalam Keluarga -->
            <label for="status_keluarga">Status Dalam Keluarga:</label>
            <select id="status_keluarga" name="status_keluarga" required>
                <option value="">Pilih Status</option>
                <option value="Anak Kandung">Anak Kandung</option>
                <option value="Anak Tiri">Anak Tiri</option>
                <option value="Anak Angkat">Anak Angkat</option>
            </select>
            <br>
            <br>            


            <h3>Data Sekolah</h3>
            <!-- Nama Asal Sekolah -->
            <label for="asal_sekolah">Nama Asal Sekolah:</label>
            <input type="text" id="asal_sekolah" name="asal_sekolah" required placeholder="Nama Sekolah">

            <!-- Nama Asal Sekolah -->
            <label for="Alamat_Sekolah">Alamat Sekolah:</label>
            <input type="text" id="Alamat_Sekolah" name="Alamat_Sekolah" required placeholder="Alamat_Sekolah">

            <!-- NPSN Sekolah Asal -->
            <label for="npsn">NPSN Sekolah Asal:</label>
            <input type="text" id="npsn" name="npsn" required placeholder="NPSN Sekolah">
            <p style="color:tomato; font-size:15px">Silahkan searching NPSN sekolah asal anda di Google jika anda tidak mengetahui nomornya</p>

            <!-- Nomor NISN -->
            <label for="nisn">Nomor NISN:</label>
            <input type="text" id="nisn" name="nisn" required placeholder="Nomor NISN">

            <!-- Jarak Rumah ke Sekolah -->
            <label for="jarak_rumah">Jarak Rumah ke Sekolah (km):</label>
            <input type="number" id="jarak_rumah" name="jarak_rumah" step="0.1" required placeholder="Jarak ke Sekolah">

            <!-- Keluhan/Penyakit -->
            <label for="keluhan">Keluhan/Penyakit:</label>
            <input type="text" id="keluhan" name="keluhan" placeholder="Keluhan/Penyakit">

             <!-- Dokumen Upload -->
             <h3 class="mt-4">Upload Dokumen</h3>
            <label for="kk" class="form-label">Upload Kartu Keluarga (KK):</label>
            <input type="file" id="kk" name="kk" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
            <p style="color:tomato; font-size:15px">Hanya file dengan format PDF, JPG, JPEG, atau PNG yang diterima</p>
            <br>
            <label for="akta" class="form-label">Upload Akta Lahir:</label>
            <input type="file" id="akta" name="akta" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
            <p style="color:tomato; font-size:15px">Hanya file dengan format PDF, JPG, JPEG, atau PNG yang diterima</p>
            <br>
            <label for="skl" class="form-label">Upload Surat Keterangan Lulus:</label>
            <input type="file" id="skl" name="skl" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
            <p style="color:tomato; font-size:15px">Hanya file dengan format PDF, JPG, JPEG, atau PNG yang diterima</p>


            <br>
            <br>

            <h3>Data Keluarga</h3>
            <!-- Nama Ayah -->
            <label for="nama_ayah">Nama Ayah:</label>
            <input type="text" id="nama_ayah" name="nama_ayah" required placeholder="Nama Ayah">

            <!-- Nama Ibu -->
            <label for="nama_ibu">Nama Ibu:</label>
            <input type="text" id="nama_ibu" name="nama_ibu" required placeholder="Nama Ibu">

            <!-- Alamat Orang Tua -->
            <label for="alamat_orang_tua">Alamat Orang Tua:</label>
            <input type="text" id="alamat_orang_tua" name="alamat_orang_tua" required placeholder="Alamat Orang Tua">

            <!-- Pekerjaan Orang Tua -->
            <label for="pekerjaan ayah">Pekerjaan Ayah:</label>
            <input type="text" id="pekerjaan ayah" name="pekerjaan ayah" required placeholder="pekerjaan ayah">
            <!-- Pekerjaan Orang Tua -->
            <label for="pekerjaan_ibu">Pekerjaan ibu:</label>
            <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" required placeholder="Pekerjaan ibu">

            <!-- Penghasilan Orang Tua/Wali -->
            <label for="gaji_orang_tua">Penghasilan Orang Tua (per bulan):</label>
            <input type="text" id="gaji_orang_tua" name="gaji_orang_tua" required placeholder="Gaji Orang Tua">
            <p style="color:tomato; font-size:15px">Input hanya menerima angka. Contoh penulisan: 1000000</p>

                <!-- Jurusan -->
            <label for="jurusan">Daftar ke jurusan:</label>
            <select id="jurusan" name="jurusan" required>
                <option value="">Pilih Jurusan</option>
                <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
                <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                <option value="Manajemen Perkantoran">Manajemen Perkantoran</option>
            </select>  

            <br><br>

            <h3>Persetujuan</h3>
            <p> Bagi calon siswa baru yang sudah daftar ulang dan dinyatakan diterima apabila mengundurkan diri/pindah 
                maka tidak ada pengembalian uang pendaftaran. Adapun berkas yang akan diserahkan kepada panitia PPDB saat daftar ulang adalah bukti fisik pendaftaran dan pembayaran anda. pastikan anda mencetak bukti fisik tersebut
                setelah anda melakukan pendaftaran dan pembayaran. Daftar ulang dilaksanakan pada tanggal 12 juli 2025 pukul 07.30 - 15.00 WIB.
            </p>
            <label class="checkbox-label">
                <input type="checkbox" name="persetujuan" required>
                <span>Saya menyetujui semua syarat dan ketentuan yang berlaku</span>
            </label>
            <br>
            <br>
            <button style=" width : 100%; border-radius:4px" type="submit">Kirim Pendaftaran</button>
            <br>
            <br>
            <button><a style="text-decoration: none;color:white;" href="pendaftaran_siswa.php">Batal</a></button>
        </form>
    </div>
    <script>
    // Validasi NIK (16 digit), telp (12 digit) & NISN (10 digit)
    document.getElementById('nik').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
    });

    document.getElementById('nisn').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
    
     document.getElementById('telp').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);
    });

    // Preview Foto
    document.getElementById('foto').addEventListener('change', function (event) {
        const reader = new FileReader();
        reader.onload = function () {
            const img = document.getElementById('previewFoto');
            img.src = reader.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
</body>

</html>
