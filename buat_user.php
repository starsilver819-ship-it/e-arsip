<?php
include 'koneksi.php';

$pass = password_hash("12345", PASSWORD_DEFAULT);

mysqli_query($koneksi,"
INSERT INTO users (nama, username, password, role)
VALUES ('Admin','admin','$pass','admin')
");

echo "User berhasil dibuat";
?>