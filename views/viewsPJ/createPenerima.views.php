<?php 

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/penerimaQuerys.php');

$object = new Querys;
$Obj = new PenerimaQuerys;
$objPath = new Paths;

$validating = $object->pj_validateSession($_SESSION['user']);

if ($validating == 0) {
	header('location:../../index.php');
}
$data = $object->sessionData($_SESSION['user']);

if (isset($_POST['SAVE'])):
    $namas = $_POST['nama'];
    $reasons = $_POST['reason'];
    $alamat = $_POST['alamat'];
    $kodepos = $_POST['kodepos'];
    $fotopenerima = $_FILES['foto_penerima']['name'];
    $fototempat = $_FILES['foto_tempatTinggal']['name'];

    $filetmp1 = $_FILES['foto_penerima']['tmp_name'];
    $filetmp2 = $_FILES['foto_tempatTinggal']['tmp_name'];

    if ($Obj->insertDataPenerima($namas, $reasons, $alamat, $kodepos, $fotopenerima, $fototempat)):
        echo "<p>succes message</p>";
        move_uploaded_file($filetmp1, $objPath->penerima_path . $fotopenerima);
        move_uploaded_file($filetmp2, $objPath->rumahpenerima_path . $fototempat);
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
    
    <form action="" method="post" enctype="multipart/form-data">
    
    Nama : <input type="text" name="nama"> <br><br>
    Alasan : <input type="text" name="reason"> <br><br>
    Alamat : <input type="text" name="alamat"> <br><br>
    Kode Pos :<input type="text" name="kodepos"> <br><br>
    Foto Pnerima : <input type="file" name="foto_penerima"> <br><br>
    Foto Tempat Tinggal Penerima <input type="file" name="foto_tempatTinggal"><br><br>

    <button type="submit" name="SAVE">Simpan Data</button>
    </form>

</body>
</html>