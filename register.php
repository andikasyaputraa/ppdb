<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role_id = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $password, $role_id);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error during registration.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Akun</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Nama User" required>
            <input type="password" name="password" placeholder="Kata Sandi" required>
            <select name="role" required>
                <!-- <option value="1">Admin</option> -->
                <option value="2">Guru</option>
                <option value="3">Siswa</option>
            </select>
            <button type="submit">Daftar</button>
        </form>
        <div class="message">
            sudah daftar? klik <a href="login.php">Masuk</a>
        </div>
    </div>
</body>
</html>
