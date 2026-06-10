<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($koneksi,"
    SELECT * FROM users
    WHERE username='$username'
    AND password='$password'
");

$cek = mysqli_num_rows($query);

if($cek > 0){

    $user = mysqli_fetch_assoc($query);

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['level'] = $user['level'];

    header("Location: index.php");
    exit;

}else{

    echo "
    <script>
        alert('Username atau Password salah!');
        window.location='login.php';
    </script>
    ";
}
?>