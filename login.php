<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){

    $u = mysqli_real_escape_string($koneksi,$_POST['username']);
    $p = md5($_POST['password']);

    $q = mysqli_query($koneksi,"
        SELECT * FROM users
        WHERE username='$u'
        AND password='$p'
    ");

    if(mysqli_num_rows($q) > 0){

        $d = mysqli_fetch_assoc($q);

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $d['id'];
        $_SESSION['nama'] = $d['nama'];
        $_SESSION['role'] = $d['role'];

        header("Location: index.php");
        exit;

    } else {

        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            height:100vh;
            background:linear-gradient(135deg,#dfefff,#f4f8ff);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .container{
            width:1100px;
            max-width:100%;
            min-height:650px;
            background:#fff;
            border-radius:25px;
            overflow:hidden;
            box-shadow:0 15px 40px rgba(0,0,0,0.12);
            display:flex;
        }

        /* LEFT */

        .left{
            width:50%;
            padding:60px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            background:#ffffff;
        }

        .logo{
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:40px;
        }
$password
        .logo-box{
            width:42px;
            height:42px;
            border-radius:12px;
            background:linear-gradient(135deg,#60a5fa,#2563eb);
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
            font-size:18px;
        }

        .logo h2{
            color:#2563eb;
            font-size:28px;
            font-weight:700;
        }

        .left h1{
            font-size:42px;
            color:#1e293b;
            margin-bottom:10px;
        }

        .subtitle{
            color:#64748b;
            margin-bottom:35px;
            line-height:1.8;
        }

        .input-group{
            margin-bottom:22px;
        }

        .input-group label{
            display:block;
            margin-bottom:8px;
            color:#334155;
            font-weight:500;
        }

        .input-box{
            position:relative;
        }

        .input-box input{
            width:100%;
            height:55px;
            border:2px solid #dbeafe;
            border-radius:14px;
            padding:0 50px;
            font-size:15px;
            transition:0.3s;
            background:#f8fbff;
        }

        .input-box input:focus{
            border-color:#60a5fa;
            outline:none;
            background:white;
            box-shadow:0 0 0 4px rgba(96,165,250,0.15);
        }

        .input-box i{
            position:absolute;
            top:50%;
            transform:translateY(-50%);
            color:#60a5fa;
        }

        .left-icon{
            left:18px;
        }

        .right-icon{
            right:18px;
            cursor:pointer;
        }

        .forgot{
            text-align:right;
            margin-top:10px;
        }

        .forgot a{
            color:#3b82f6;
            text-decoration:none;
            font-size:14px;
        }

        .login-btn{
            width:100%;
            height:55px;
            border:none;
            border-radius:14px;
            margin-top:20px;
            background:linear-gradient(135deg,#60a5fa,#2563eb);
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            box-shadow:0 10px 20px rgba(37,99,235,0.25);
        }

        .login-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 14px 25px rgba(37,99,235,0.35);
        }

        .error{
            background:#fee2e2;
            color:#dc2626;
            padding:14px;
            border-radius:12px;
            margin-bottom:20px;
            font-size:14px;
        }

        .divider{
            display:flex;
            align-items:center;
            margin:30px 0;
            color:#94a3b8;
            font-size:14px;
        }

        .divider::before,
        .divider::after{
            content:'';
            flex:1;
            height:1px;
            background:#e2e8f0;
        }

        .divider span{
            margin:0 15px;
        }

        .social-btn{
            width:100%;
            height:52px;
            border:2px solid #e2e8f0;
            border-radius:14px;
            background:white;
            margin-bottom:15px;
            cursor:pointer;
            font-size:15px;
            transition:0.3s;
        }

        .social-btn:hover{
            background:#f8fbff;
            border-color:#bfdbfe;
        }

        .social-btn i{
            margin-right:10px;
        }

        .signup{
            text-align:center;
            margin-top:20px;
            color:#64748b;
        }

        .signup a{
            color:#2563eb;
            text-decoration:none;
            font-weight:600;
        }

        /* RIGHT */

        .right{
            width:50%;
            background:linear-gradient(135deg,#60a5fa,#3b82f6,#2563eb);
            padding:60px;
            color:white;
            display:flex;
            flex-direction:column;
            justify-content:center;
            position:relative;
            overflow:hidden;
        }

        .right::before{
            content:'';
            position:absolute;
            width:350px;
            height:350px;
            border-radius:50%;
            background:rgba(255,255,255,0.10);
            top:-60px;
            right:-100px;
        }

        .right::after{
            content:'';
            position:absolute;
            width:250px;
            height:250px;
            border-radius:50%;
            background:rgba(255,255,255,0.08);
            bottom:-80px;
            left:-80px;
        }

        .right h1{
            font-size:48px;
            line-height:1.3;
            margin-bottom:25px;
            position:relative;
            z-index:2;
        }

        .right p{
            font-size:18px;
            line-height:1.9;
            opacity:0.95;
            position:relative;
            z-index:2;
        }

        .user-box{
            display:flex;
            align-items:center;
            margin-top:40px;
            position:relative;
            z-index:2;
        }

        .user-box img{
            width:60px;
            height:60px;
            border-radius:50%;
            margin-right:15px;
            border:3px solid rgba(255,255,255,0.4);
        }

        .user-box h4{
            font-size:18px;
        }

        .user-box span{
            font-size:14px;
            opacity:0.8;
        }

        .brand-list{
            margin-top:70px;
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:15px;
            position:relative;
            z-index:2;
        }

        .brand{
            background:rgba(255,255,255,0.12);
            padding:12px;
            border-radius:12px;
            text-align:center;
            backdrop-filter:blur(5px);
            font-size:14px;
        }

        @media(max-width:900px){

            .container{
                flex-direction:column;
            }

            .left,
            .right{
                width:100%;
            }

            .left{
                padding:40px;
            }

            .right{
                padding:40px;
            }

            .right h1{
                font-size:36px;
            }

        }

    </style>
</head>

<body>

<div class="container">

    <!-- LEFT -->

    <div class="left">

        <div class="logo">
            <div class="logo-box">
                <i class="fa-solid fa-folder-open"></i>
            </div>

            <h2>E-Arsip</h2>
        </div>

        <h1>Welcome Back!</h1>

        <p class="subtitle">
            Silakan login untuk mengakses dashboard aplikasi arsip digital.
        </p>

        <?php if(isset($error)) : ?>
            <div class="error">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="input-group">

                <label>Username</label>

                <div class="input-box">
                    <i class="fa-regular fa-user left-icon"></i>

                    <input 
                        type="text" 
                        name="username" 
                        placeholder="Masukkan username"
                        required
                    >
                </div>

            </div>

            <div class="input-group">

                <label>Password</label>

                <div class="input-box">

                    <i class="fa-solid fa-lock left-icon"></i>

                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Masukkan password"
                        required
                    >

                    <i 
                        class="fa-regular fa-eye-slash right-icon"
                        id="togglePassword"
                    ></i>

                </div>

                <div class="forgot">
                    <a href="#">Lupa Password?</a>
                </div>

            </div>

            <button type="submit" name="login" class="login-btn">
                Login Sekarang
            </button>

        </form>

        <div class="divider">
            <span>ATAU</span>
        </div>

        <button class="social-btn">
            <i class="fa-brands fa-google"></i>
            Login dengan Google
        </button>

        <button class="social-btn">
            <i class="fa-brands fa-apple"></i>
            Login dengan Apple
        </button>

        <div class="signup">
            Sistem Informasi Arsip Digital
        </div>

    </div>

    <!-- RIGHT -->

    <div class="right">

        <h1>
            Kelola Arsip Lebih Cepat & Modern
        </h1>

        <p>
            Sistem digital untuk pengelolaan surat masuk, surat keluar,
            disposisi, laporan, dan arsip elektronik secara aman dan profesional.
        </p>

        <div class="user-box">

            <img src="" alt="">

            <div>
                <h4>Administrator</h4>
                <span>Pengelola Arsip Digital</span>
            </div>

        </div>

        <div class="brand-list">

            <div class="brand">Dashboard</div>
            <div class="brand">Surat Masuk</div>
            <div class="brand">Surat Keluar</div>
            <div class="brand">Disposisi</div>
            <div class="brand">Laporan</div>
            <div class="brand">QR Code</div>

        </div>

    </div>

</div>

<script>

    // SHOW HIDE PASSWORD

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {

        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';

        password.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');

    });

</script>

</body>
</html>