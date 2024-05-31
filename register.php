<?php
session_start();

// Jika pengguna sudah login, alihkan ke halaman lain
if (isset($_SESSION['session_username'])) {
    header("Location: index.php"); // Jika sudah login, alihkan ke halaman utama
    exit();
}

// Database Connection Setup
$host_db    = "localhost";
$user_db    = "root";
$pass_db    = "";
$nama_db    = "loginfilm";
$koneksi    = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);

// Variabel untuk pesan error dan inputan pengguna
$err        = "";
$username   = "";
$password   = "";
$confirm_password = "";

// Proses Registrasi
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validasi input
    if ($username == '' || $password == '' || $confirm_password == '') {
        $err .= "<li>Semua field wajib diisi.</li>";
    } elseif ($password !== $confirm_password) {
        $err .= "<li>Password tidak cocok.</li>";
    } else {
        // Periksa apakah username sudah ada di database
        $sql_check = "SELECT * FROM login WHERE username = '$username'";
        $query_check = mysqli_query($koneksi, $sql_check);

        if (mysqli_num_rows($query_check) > 0) {
            $err .= "<li>Username <b>$username</b> sudah digunakan.</li>";
        } else {
            // Jika valid, insert ke database dengan password yang di-hash
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO login (username, password) VALUES ('$username', '$hashed_password')";
            $query_insert = mysqli_query($koneksi, $sql_insert);

            if ($query_insert) {
                header("Location: login.php"); // Redirect ke halaman login setelah berhasil registrasi
                exit();
            } else {
                $err .= "<li>Terjadi kesalahan saat mendaftarkan pengguna.</li>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
  background-color: #000;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.panel-info {
  background-color: rgb(56, 56, 56) !important;
  border-color: black;
}

.panel-heading {
  color: #000;
  background-color: aquamarine !important;
  border-color: rgb(17, 17, 17) !important;
}

.panel-title {
  color: black;
  font-weight: bold;
}

.form-control {
  background-color: #ffffff;
  color: #000;
 
}

.form-control:focus {
  border-color: rgb(44, 44, 44);
  background-color: #000;
  color: #fff;
}

.btn-primary {
  background-color: aquamarine;
  border-color: aquamarine;
  color: #000;
}

.btn-primary:hover {
  background-color: #fff;
 
  color: #000;
}

.btn-link {
  color: rgb(255, 255, 255);
}

.btn-link:hover {
  color: #fff;
}

    </style>

</head>
<body>
<div class="container my-4">    
    <div id="registerbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Registrasi Pengguna Baru</div>
            </div>      
            <div style="padding-top:30px" class="panel-body">
                <?php if ($err): ?>
                    <div class="alert alert-danger">
                        <ul><?php echo $err; ?></ul>
                    </div>
                <?php endif; ?>
                <form id="registerform" class="form-horizontal" action="" method="post" role="form">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmasi Password">
                    </div>
                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <input type="submit" name="register" class="btn btn-primary" value="Daftar"/>
                        </div>
                    </div>
                </form>    
            </div>                     
        </div>  
    </div>
</div>
</body>
</html>
