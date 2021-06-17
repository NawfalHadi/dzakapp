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
if(!$object->getDetailHistory($_GET['id_zakatReq'])) die ('error message 1');

require_once ('../../funcs/hijriDate.funcs.php');
$hijri = new HijriDate;

$zakatObject = new Zakats;
if(!$zakatObject->getDataReq($object->getIDzakatreq)) die ('error message 2');
    
if(isset($_POST['PAY'])){
    $value_buktiPembayaran = $_FILES['bukti_pembayaran']['name'];
    $value_tanggalPembayaran = $_POST['tanggal_pembayaran'];
    $value_tahunHijri = $hijri->get_year();

    $statuszakat = 'proses';
	$idreq = $zakatObject->data_idzakatreq;

    $tmp_buktiPembayaran = $_FILES['bukti_pembayaran']['tmp_name'];

    if($zakatObject->changeStatus($statuszakat, $idreq)){
		if($zakatObject->pendingProses($value_buktiPembayaran, $value_tanggalPembayaran, $value_tahunHijri, $object->getIDzakathist)){
			move_uploaded_file($tmp_buktiPembayaran, $objPath->paymentMal_path . $value_buktiPembayaran);
            header('location:mainFitrah.views.php');
            echo "succes Message";
		}else{
			echo "Failed Message";
		}
	}else{
        echo "Failed Message";
	}
        
        
}

$pjesObject = new PjesQuerys;
if(!$pjesObject->getDetailPJ($object->getIDpj)) die ('error message 3');

$pemberiObject = new UserQuerys;
if(!$pemberiObject->getDetailBiodata($pjesObject->getIDbiodata)) die ('error message');

$penerimaOject = new PenerimaQuerys;

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
</head>
<body>
<!-- Sidebar -->
      <?php include('../sidebar.views.php') ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
        <?php $title = "Zakat Mal"; include('../../header.views.php'); ?>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Biodata Diri</h3>
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
                        <td>: <?php echo $data['alamat_lengkap']; ?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></td>
                     </tr>
                  </table>
                  <br>
               </div>
            </div>            
         </div>

         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Informasi Transaksi</h3>
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>ID Transaksi </td>
                        <td>: <?php echo $object->getIDzakathist ?></td>
                     </tr>
                     <tr>
                        <td>Nominal yang harus di bayar </td>
                        <td>: Rp. <b><?php echo $zakatObject->data_zakatamount ?></b></td>
                     </tr>
                     <tr>
                        <td>Jenis zakat </td>
                        <td>: <?php echo $zakatObject->data_zakattype?></td>
                     </tr>         
                     <tr>
                        <td>Penanggung Jawab </td>
                        <td>: <?php echo $pemberiObject->get_nama ?></td>
                     </tr>
                  </table>
                  <br>
               </div>
            </div>            
         </div>
        <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Pembayaran Zakat</h3>
               </header>
               <div class="w3-container">                  
                  <p>Lakukan pembayaran dengaan menggunakan</p>
                  <h5>Bank   : <b><?php echo $pjesObject->getDebitCard ?></b></h2>
                  <h5>No Rek : <b><?php echo $pjesObject->getNoRek ?></b></h3>
                  <p>1. Transfer nominal ke nomor rekening yang ada diatas ini</p>
                  <p>2. Setelah transfer selesai foto bukti transfer nya ke form yang sudah disediakan dibawah</p>
                  <p>3. Klik pada tulisan bayar</p>
                  <p>4. Tunggu Dikonfirmasi dari penanggung jawabnya</p>
                  <p>5. Jika masih belum dikonfirmasi, maka bisa menghubungi penanggung jawabnya pada nomor dibawah ini</p>
                  <p>Nomor Telepon Penanggung Jawab : <b><?php echo $pjesObject->getPhoneNo ?></b></b></p>
               </div>
            </div>
        </div>

        <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Upload Bukti Pembayaran</h3>
               </header>
               <div class="w3-container">
                  <br>
                    <form action="" enctype="multipart/form-data" method="POST">
                    Upload Bukti Pembayaran Disini : <input type="file" name="bukti_pembayaran">
                    <input type="hidden" name="tanggal_pembayaran" value="<?php echo date("Y-m-d"); ?>">
                    <br><br>
                    <button type="submit" name="PAY">BAYAR</button>
                    </form>
                  <br>
               </div>
            </div>            
         </div>
         <br><br>
    </div>    
</body>
</html>