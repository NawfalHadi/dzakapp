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
if(!$Obj->getDataPenerima($_GET['id_penerima'])) die ('error message');

if (isset($_POST['EDIT'])):
    $namas = $_POST['nama'];
    $reasons = $_POST['reason'];
    $alamat = $_POST['alamat'];
    $kodepos = $_POST['kodepos'];

    if ($Obj->editDataPenerima($namas, $reasons, $alamat, $kodepos, $Obj->foto_penerima, $Obj->foto_tempatTinggal, $Obj->id_penerima)):
        echo "<p>succes message</p>";
        header('location:listPenerima.views.php');   
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

    <style>
    
    </style>

</head>
<body>

<h1>Edit Biodata Penerima</h1>

<form action="" method="post">
    
    Nama : <input type="text" name="nama" value="<?php echo $Obj->nama ?>"> <br><br> 
    Alasan : <input type="text" name="reason" value="<?php echo $Obj->reason ?>""> <br><br>
    Alamat : <input type="text" name="alamat" value="<?php echo $Obj->alamat_lengkap ?>"> <br><br>
    Kode Pos :<input type="text" name="kodepos" value="<?php echo $Obj->kode_pos ?>"> <br><br>

    <button type="submit" name="EDIT">Simpan Data Baru</button>


</form>
    
</body>
</html>