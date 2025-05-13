<?php
session_start(); // Memulai session
include 'includes/db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'] ?? ''; // Jika tidak ada fullname, set string kosong
    $role_id = $_POST['role_id']; // Ambil role_id dari form
    $password = $_POST['password'];

    // Validasi input
    if (empty($fullname)) {
        $error = "Nama lengkap tidak boleh kosong.";
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid.";
    } elseif (strlen($password) < 8 || 
              !preg_match('/[A-Z]/', $password) || 
              !preg_match('/[a-z]/', $password) || 
              !preg_match('/[0-9]/', $password) || 
              !preg_match('/[\W]/', $password)) {
        $error = "Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter khusus.";
    } else {
        // Cek apakah email sudah terdaftar
        if ($role_id == 1) {
            $check_sql = "SELECT id FROM users WHERE email = ?";
        } elseif ($role_id == 2) {
            $check_sql = "SELECT id FROM admin WHERE email = ?";
        } else {
            $error = "Role tidak valid.";
        }

        if (!isset($error)) {
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                $error = "Email sudah terdaftar. Silakan gunakan email lain.";
            } else {
                // Hash password setelah validasi berhasil
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Menentukan tabel tujuan berdasarkan role_id
                if ($role_id == 1) {
                    $sql = "INSERT INTO users (email, fullname, password, role_id) VALUES (?, ?, ?, ?)";
                } elseif ($role_id == 2) {
                    $sql = "INSERT INTO admin (email, fullname, password, role_id) VALUES (?, ?, ?, ?)";
                }

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $email, $fullname, $hashed_password, $role_id);

                if ($stmt->execute()) {
                    $_SESSION['registration_success'] = "Registrasi berhasil! Silakan login.";
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Terjadi kesalahan saat registrasi: " . $stmt->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/register.css">
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px; /* Ruang untuk ikon */
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        p{
            font-size:10px;
            color:tomato;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Akun</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="fullname" placeholder="Nama Lengkap" required>
            
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Kata Sandi" required 
                       minlength="8" 
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}" 
                       title="Minimal 8 karakter, harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus">
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>
             <p>Password minimal 8 karakter, wajib ada huruf besar, kecil, angka & simbol.</p>

            <select name="role_id" required>
                <option value="">Pilih Role</option>
                <option value="1">Calon Siswa</option>
                <!--<option value="2">Admin</option>-->
            </select>
            <button type="submit">Daftar</button>
        </form>
        <div class="message">
            Sudah punya akun? <a href="login.php">Klik masuk di sini</a>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            let input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
