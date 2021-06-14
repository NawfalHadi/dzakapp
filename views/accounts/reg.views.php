<?php 

    require_once ('../../databases/databases.db.php');
    require_once ('../../queries/users/userQuerys.php');

    $usersObj = new userQuerys;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'):
        $nama = $_POST['nama'];
        $email = $_POST['emails'];
        $pass = $_POST['pass'];
        $kodpos = $_POST['kode_pos'];
        $rt = $_POST['rt'];
        $rw = $_POST['rw'];
        $nomrum = $_POST['nomor_rumah'];
        $alamatkap = $_POST['alamat_lengkap'];

        if ($usersObj->regUsers($nama, $email, $pass, $kodpos, $rt, $rw, $nomrum, $alamatkap)):
            header('location:../../index.php');
        else:
            echo "<p>error message</p>";
        endif;
    endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registert</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
      <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>


    <center>
        <div class="w3-card-4" style="max-width:600px; margin-top: 80px">
        <br>
            <h1>Register</h1>
            <form class="w3-container" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
               <div class="w3-section">
                  <label><b>Nama</b></label><br><br>
                  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Nama" name="nama" required>
                  <label><b>Email</b></label><br><br>
                  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Email" name="emails" required>
                  <label><b>Password</b></label><br><br>
                  <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="pass" required>
                  <label><b>Kode Pos</b></label><br><br>
                  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Kode Pos" name="kode_pos" required>
                  <label><b>RT</b></label><br><br>
                  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter RT" name="rt" required>
                  <label><b>RW</b></label><br><br>
                  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter RW" name="rw" required>
                  <label><b>Nomor Rumah</b></label><br><br>
                  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Nomor Rumah" name="nomor_rumah" required>
                  <label><b>Alamat Lengkap</b></label><br><br>
                  <textarea class="w3-input w3-border w3-margin-bottom" placeholder="Enter Alamat Lengkap" name="alamat_lengkap" required></textarea>
                  <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Register</button>
               </div>
            </form>
            Already Have Account ? <a href="../../">Login</a>
            <br><br>
        </div>
        <br><br><br><br>
    </center>

    <!-- <form action="" method="post">
        Nama : <input type="text" name="nama"><br>
        Email : <input type="email" name="email"><br>
        Password :<input type="password" name="pass"><br>
        Kode Pos : <input type="number" name="kode_pos"><br>
        Rt :<input type="number" name="rt"><br>
        Rw : <input type="number" name="rw"><br>
        Nomor Rumah :<input type="number" name="nomor_rumah"><br>
        Alamat Lengkap : <input type="text" name="alamat_lengkap"><br>

        <button type="submit">SAVE</button>
    </form> -->
    
</body>
</html>