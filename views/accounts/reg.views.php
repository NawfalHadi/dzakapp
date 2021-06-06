<?php 

    require_once ('../../databases/databases.db.php');
    require_once ('../../queries/users/userQuerys.php');

    $usersObj = new userQuerys;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'):
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $kodpos = $_POST['kode_pos'];
        $rt = $_POST['rt'];
        $rw = $_POST['rw'];
        $nomrum = $_POST['nomor_rumah'];
        $alamatkap = $_POST['alamat_lengkap'];

        if ($usersObj->regUsers($nama, $email, $pass, $kodpos, $rt, $rw, $nomrum, $alamatkap)):
            echo "<p>succes message</p>";
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
    <title>Document</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <input type="text" name="nama"><br>
    <input type="email" name="email"><br>
    <input type="password" name="pass"><br>
    <input type="number" name="kode_pos"><br>
    <input type="number" name="rt"><br>
    <input type="number" name="rw"><br>
    <input type="number" name="nomor_rumah"><br>
    <input type="text" name="alamat_lengkap"><br>

    <button type="submit">SAVE</button>
</form>
    
</body>
</html>