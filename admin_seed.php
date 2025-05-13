<?php
include 'includes/db.php';

// Data admin default
$admin_email = "admin@smkhijaumuda.com";
$admin_password = password_hash("admin123", PASSWORD_DEFAULT); // Gunakan password hash
$admin_fullname = "Administrators";
$admin_role_id = 2; // Sesuaikan dengan role_id untuk admin

// Cek apakah admin sudah ada
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Jika belum ada, tambahkan admin default
    $insert_sql = "INSERT INTO users (fullname, email, password, role_id) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sssi", $admin_fullname, $admin_email, $admin_password, $admin_role_id);

    if ($insert_stmt->execute()) {
        echo "Admin default berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan admin default: " . $conn->error;
    }
} else {
    echo "Admin default sudah ada di database.";
}

$stmt->close();
$conn->close();
?>
