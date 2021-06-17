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
$biodataPJObject = new UserQuerys;
if(!$pjesObject->getDetailPJ($object->getIDpj)) die ('error message');
if(!$biodataPJObject->getDetailBiodata($pjesObject->getIDbiodata)) die ('error message');

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
			move_uploaded_file($tmp_buktiPemberian, $objPath->giftFitrah_path . $value_buktiPemberian);
            header('location:mainFitrah.views.php');
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
    
    img {
        width: 200px;
        height: 200px;
    }

    .img-buktiBayar {
        width: 200px;
        height: 280px;
    }

    .img-buktiTerima {
        width: 220px;
        height: 200px;
    }

    .img-penerima {
        width: 100px;
        height : 100px;
    }

    </style>

</head>
<body>
<!-- Sidebar -->
      <?php include('../sidebar.views.php') ?>
      <!-- Page Content -->
      <div style="margin-left:2.9%">
         <?php $title = "Detail Transaksi"; include('../../header.views.php');?>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Biodata profile</h3>
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Nama </td>
                        <td>: <?php echo $data['nama']; ?></td>
                     </tr>
                     <tr>
                        <td>Email </td>
                        <td>: <?php echo $data['emails']; ?></td>
                     </tr>
                     <tr>
                        <td>Alamat Lengkap </td>
                        <td>: <?php echo $data['alamat_lengkap']; ?>, Rt <?php echo $data['rt']; ?>, Rw <?php echo $data['rw'];?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $data['kode_pos']; ?></td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>ID Transaksi : <?php echo $object->getIDzakathist ?></h3>
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Pembayaran Untuk Tahun</td>
                        <td>: <?php echo $object->tahun_hijri ?> Hijriah </td>
                     </tr>
                     <tr>
                        <td>Bukti Pembayaran </td>
                        <td>: <img class="img-buktiBayar" src="<?php echo $objPath->paymentFitrah_path.$object->bukti_pembayaran ?>">
                        <br>tgl pembayaran :<?php echo $object->tanggal_pembayaran ?></td>
                     </tr>
                     <tr>
                        <td>Bukti Penerimaan</td>
                        <td>: <img class="img-buktiTerima" src="<?php echo $objPath->giftFitrah_path.$object->bukti_pemberian ?>">
                        <br>tgl penyerahan :<?php echo $object->tanggal_pemberian ?></td>
                     </tr>
                  </table>
                  <br><br>
               </div>
            </div>
         </div>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Biodata PJ</h3>
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Profile</td>
                        <td>: <img src="<?php echo $objPath->ktpUser_path.$pjesObject->getKtpAndUser ?>" alt=""></td>
                     </tr>
                     <tr>
                        <td>Nama </td>
                        <td>: <?php echo $biodataPJObject->get_nama ?></td>
                     </tr>
                     <tr>
                        <td>Email </td>
                        <td>: <?php echo  $biodataPJObject->get_emails ?></td>
                     </tr>
                     <tr>
                        <td>Alamat Lengkap </td>
                        <td>: <?php echo  $biodataPJObject->get_alamatlengkap ?>, Rt <?php echo  $biodataPJObject->get_rt ?>, Rw <?php echo  $biodataPJObject->get_rw ?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo  $biodataPJObject->get_kode_pos ?></td>
                     </tr>
                  </table>
                  <br>
               </div>
            </div>
         </div>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Biodata Penerima</h3>
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Nama </td>
                        <td>: <?php echo $penerimaOject->nama ?></td>
                     </tr>
                     <tr>
                        <td>Alasan Berhak </td>
                        <td>: <?php echo $penerimaOject->reason ?></td>
                     </tr>
                     <tr>
                        <td>Alamat Lengkap </td>
                        <td>: <?php echo $penerimaOject->alamat_lengkap ?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $penerimaOject->kode_pos ?></td>
                     </tr>
                     <tr>
                        <td>Foto Penerima </td>
                        <td>: <img src="<?php echo $objPath->penerima_path.$penerimaOject->foto_penerima ?>"></td>
                        <td>Foto Tempat Tinggal</td>
                        <td>: <img src="<?php echo $objPath->rumahpenerima_path.$penerimaOject->foto_tempatTinggal ?>"></td>
                     </tr>
                  </table>
                  <br><br>
               </div>
            </div>
         </div>
      </div> 
</body>
</html>