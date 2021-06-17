<?php 

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/systems/zakats.php');
require_once ('../../queries/users/pjesQuerys.php');
require_once ('../../queries/users/userQuerys.php');
require_once ('../../queries/users/penerimaQuerys.php');

$object = new Querys;
$objPath = new Paths;

$data = $object->sessionData($_SESSION['user']);

// Zakat Dari History
if(!$object->getDetailHistory($_GET['id_zakatReq'])) die ('error message');

require_once ('../../funcs/hijriDate.funcs.php');
$hijri = new HijriDate;

// Zakat Dari Request
$zakatObject = new Zakats;
if(!$zakatObject->getDataReq($object->getIDzakatreq)) die ('error message');

// Biodata PJ
$pjesObject = new PjesQuerys;
$biodataObject = new UserQuerys;
if(!$pjesObject->getDetailPJ($object->getIDpj)) die ('error message');
if(!$biodataObject->getDetailBiodata($pjesObject->getIDbiodata)) die ('error message');

// Biodata Pemberi
$pemberiObject = new UserQuerys;
if(!$pemberiObject->getDetailBiodata($zakatObject->data_idbiodatapemberi)) die ('error message');

$penerimaOject = new PenerimaQuerys;
if(!$penerimaOject->getDataPenerima($object->getIDpenerima)) die ('error message');

if(isset($_POST['CONFIRM'])){
    $value_buktiPemberian = $_FILES['bukti_pemberian']['name'];
    $value_tanggalPemberian = $_POST['tanggal_pemberiam'];

    $statuszakat = 'lunas';
	$idreq = $zakatObject->data_idzakatreq;

    $tmp_buktiPemberian = $_FILES['bukti_pemberian']['tmp_name'];

    if($zakatObject->changeStatus($statuszakat, $idreq)){
		if($zakatObject->pendingToLunas($value_buktiPemberian, date('Y-m-d'), $object->getIDzakathist)){
			move_uploaded_file($tmp_buktiPemberian, $objPath->giftMal_path . $value_buktiPemberian);
            header('location:../viewsPJ/listRequestZakat.php');
            echo "succes Message";
		}else{
			echo "Failed Message";
		}
	}else{
        echo "Failed Message";
	}
    
}


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
    
    img {
        width: 200px;
        height: 280px;
    }

    .img-penerima {
        width: 100px;
        height : 100px;
    }

    </style>

</head>
<body>
<!-- Sidebar -->
      <?php include('../sidebar.views.php'); ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
         <?php $title = "Confirm Transaksi"; include('../../header.views.php') ?>
         <div class="w3-container">
            <div class="w3-card-4" style="margin-top: 10px">
               <header class="w3-container w3-light-grey">
                  <h3>Biodata Pemberi</h3>
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Nama </td>
                        <td>: <?php echo $pemberiObject->get_nama?></td>
                     </tr>
                     <tr>
                        <td>Email </td>
                        <td>: <?php echo $pemberiObject->get_emails?></td>
                     </tr>
                     <tr>
                        <td>Alamat Lengkap </td>
                        <td>: <?php echo $pemberiObject->get_alamatlengkap?> Rt : <?php echo $pemberiObject->get_rt?> Rw : <?php echo $pemberiObject->get_rw?> Nomor Rumah : <?php echo $pemberiObject->get_nomorrumah?></td>
                     </tr>
                  </table>
                  <br>
               </div>
            </div>
         </div>
         <div class="w3-container">
            <div class="w3-card-4" style="margin-top: 10px">
               <header class="w3-container w3-light-grey">
                  <h3>Biodata Penerima</h3>
               </header>
               <div class="w3-container">
               <br>
               <center>
                  <img src="<?php echo $objPath->penerima_path. $penerimaOject->foto_penerima?>" alt="" style="width: 180px;height: 180px" >
                  <img src="<?php echo $objPath->rumahpenerima_path. $penerimaOject->foto_tempatTinggal?>" alt="" style="width: 180px;height: 180px">
                  <br><br>
                </center>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Nama </td>
                        <td>: <?php echo $penerimaOject->nama?></td>
                     </tr>
                     <tr>
                        <td>Reason </td>
                        <td>: <?php echo $penerimaOject->reason?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $penerimaOject->kode_pos?></td>
                     </tr>
                     <tr>
                        <td>Alamat Lengkap </td>
                        <td>: <?php echo $penerimaOject->alamat_lengkap?>
                     </tr>
                     <tr>
                        <td>Bukti Penyerahan</td>
                        <td>
                           <form action="" enctype="multipart/form-data" method="post">
                              <input type="file" name="bukti_pemberian"><br>
                        </td>
                     </tr>
                  </table>
                  <center>
                  <br><br>
                  <button type="submit" name="CONFIRM"> CONFIRM </button>
                  </center>
                  </form>
                  <br>
               </div>
            </div>
         </div>
      </div>
</body>
</html>