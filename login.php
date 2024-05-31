<?php
session_start();

// Jika pengguna sudah login, alihkan ke halaman lain
if (isset($_SESSION['session_username'])) {
    header("Location: index.php"); // Jika sudah login, arahkan ke halaman utama
    exit();
}

// Database Connection Setup
$host_db    = "localhost";
$user_db    = "root";
$pass_db    = "";
$nama_db    = "loginfilm";
$koneksi    = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Variabel untuk pesan error dan inputan pengguna
$err        = "";
$username   = "";
$password   = "";

// Proses Login
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == '' || $password == '') {
        $err .= "<li>Silakan masukkan username dan password.</li>";
    } else {
        // Periksa apakah username ada di database
        $sql = "SELECT * FROM login WHERE username = '$username'";
        $result = mysqli_query($koneksi, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verifikasi kata sandi dengan password_verify
            if (password_verify($password, $user['password'])) {
                // Sesi untuk pengguna yang berhasil login
                $_SESSION['session_username'] = $username;

                header("Location: index.php"); // Redirect setelah login berhasil
                exit();
            } else {
                $err .= "<li>Password yang dimasukkan salah.</li>";
            }
        } else {
            $err .= "<li>Username <b>$username</b> tidak tersedia.</li>";
        }
    }
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="gaya.css">
    <style>
   .body{
    font-family: "Poppins", sans-serif;
   }
.btn-link {
            color: white;
        }
        .mainbox .panel-info > .panel-heading {
            background-color: aquamarine !important;
            color: white !important; 
        }

        .mainbox .panel-info > .panel-heading .panel-title {
            color: black !important; 
        }
.panel-title{
    font-weight: bold;
}
    </style>
</head>
<body>
<div class="container my-4">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Login</div>
            </div>
            <div style="padding-top:30px" class="panel-body">
                <?php if ($err): ?>
                    <div class="alert alert-danger">
                        <ul><?php echo $err; ?></ul>
                    </div>
                <?php endif; ?>
                <form id="loginform" class="form-horizontal" action="" method="post" role="form">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="password">
                    </div>
                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <input type="submit" name="login" class="btn btn-success" value="Login"/>
                        </div>
                    </div>
                    <div>
                        <a href="register.php" class="btn btn-link">Belum punya akun? Daftar di sini</a> <!-- Link ke halaman registrasi -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Periksa apakah pengguna sudah login
$is_logged_in = isset($_SESSION['session_username']);
$logged_in_username = $is_logged_in ? $_SESSION['session_username'] : null;

// Logika untuk tombol logout
if (isset($_GET['logout'])) {
    // Hapus semua sesi
    session_unset();
    session_destroy();

    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>

</body>
</html>
