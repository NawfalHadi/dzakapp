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
    <!-- Core theme CSS (includes Bootstrap)-->
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    
    </style>

</head>
<body>
<!-- Sidebar -->
      <?php include('../sidebar.views.php'); ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
      <?php $title = 'Data Penerima'; include ('../../header.views.php'); ?>
      <div class="w3-container" style="margin-left: 35px; margin-top: 25px; margin-right: 40px">
            <div class="w3-card-4" style="border-radius: 10px;">
                     <header class="w3-container w3-light-grey">
                        <h3>Edit Biodata Penerima</h3>
                     </header>
                     <br>
                     <form class="w3-container" action="" method="post">
                        <label>Nama</label>
                        <input type="text" name="nama" class="w3-input w3-border" value="<?php echo $Obj->nama ?>">

                        <label>Alasan</label>
                        <input type="text" name="reason" class="w3-input w3-border" value="<?php echo $Obj->reason ?>">

                        <label>Alamat</label>
                        <input type="text" name="alamat"class="w3-input w3-border" value="<?php echo $Obj->alamat_lengkap ?>">

                        <label>Kode Pos</label>
                        <input type="text" name="kodepos" class="w3-input w3-border" value="<?php echo $Obj->kode_pos ?>">

                        <button class="w3-btn w3-blue w3-section w3-padding" type="submit" name="EDIT">Simpan Peubahan</button>
                     </form>
                  </div>
                  <br>
            </div> 
         </div>
      </div>
</body>
</html>