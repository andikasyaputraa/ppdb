<?php
session_start();
include 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$notif = ""; // Hindari error undefined variable

if (!isset($_GET['token'])) {
    die("Token tidak ditemukan.");
}

$token = $_GET['token'];

// Cek token di database
$sql = "(SELECT id, email, reset_token_expiry FROM users WHERE reset_token = ?) 
        UNION 
        (SELECT id, email, reset_token_expiry FROM admin WHERE reset_token = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $token, $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Token tidak valid atau sudah digunakan.");
}

$user = $result->fetch_assoc();
$user_id = $user['id']; // Pastikan $user_id dideklarasikan

// Cek apakah token sudah kedaluwarsa
if (strtotime($user['reset_token_expiry']) < time()) {
    die("Token sudah kadaluwarsa. Silakan buat permintaan reset baru.");
}

// Simpan email ke session agar digunakan saat reset password
$_SESSION['reset_email'] = $user['email'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px; /* Beri ruang untuk ikon */
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
        <h2>Atur Ulang Password</h2>

        <form action="process_reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

            <div class="password-container">
                <input type="password" id="new_password" name="new_password" placeholder="Masukkan Password Baru" required 
                    minlength="8"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}"
                    title="Minimal 8 karakter, harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus">
                <span class="toggle-password" onclick="togglePassword('new_password')">👁️</span>
            </div>
            <p>Password minimal 8 karakter, wajib ada huruf besar, kecil, angka & simbol.</p>

            <div class="password-container">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password Baru" required>
                <span class="toggle-password" onclick="togglePassword('confirm_password')">👁️</span>
            </div>

            <button type="submit">Reset Password</button>
        </form>

        <div class="message">
            <a href="login.php">Kembali ke Login</a>
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

