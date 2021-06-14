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
        move_uploaded_file($filetmp1, $objPath->penerima_path . $fotopenerima);
        move_uploaded_file($filetmp2, $objPath->rumahpenerima_path . $fototempat);
    else:
        null;
    endif;
endif;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Document</title>
    <!-- Favicon-->
      <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
      <!-- Core theme CSS (includes Bootstrap)-->
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <?php include ('../sidebar.views.php') ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
         <?php $title = 'Tambah Data Penerima'; include('../../header.views.php'); ?>
         <div class="w3-container" style="margin-left: 35px; margin-top: 25px; margin-right: 40px">
            <div class="w3-card-4" style="border-radius: 10px;">
                     <header class="w3-container w3-light-grey">
                        <h3>Tambah Penerima</h3>
                     </header>
                     <br>
                     <form class="w3-container" action="" method="post" enctype="multipart/form-data">
                        <label>Nama</label>
                        <input type="text" name="nama" class="w3-input w3-border">

                        <label>Alasan</label>
                        <input type="text" name="reason" class="w3-input w3-border">

                        <label>Alamat</label>
                        <input type="text" name="alamat"class="w3-input w3-border">

                        <label>Kode Pos</label>
                        <input type="text" name="kodepos" class="w3-input w3-border">

                        <label>Foto Penerima</label>
                        <input type="file" name="foto_penerima" class="w3-input w3-border">

                        <label>Foto Tempat Tinggal Penerima</label>
                        <input type="file" name="foto_tempatTinggal" class="w3-input w3-border">

                        <button class="w3-btn w3-blue w3-section w3-padding" type="submit" name="SAVE">Daftar</button>
                     </form>
                  </div>
                  <br>
            </div> 
         </div>
      </div>
</body>
</html>