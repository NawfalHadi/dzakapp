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
if(!$object->getDetailHistory($_GET['id_zakatReq'])) die ('error message');

require_once ('../../funcs/hijriDate.funcs.php');
$hijri = new HijriDate;

$zakatObject = new Zakats;
if(!$zakatObject->getDataReq($object->getIDzakatreq)) die ('error message');
    
if(isset($_POST['PAY'])){
    $value_buktiPembayaran = $_FILES['bukti_pembayaran']['name'];
    $value_tanggalPembayaran = $_POST['tanggal_pembayaran'];
    $value_tahunHijri = $hijri->get_year();

    $statuszakat = 'proses';
	$idreq = $zakatObject->data_idzakatreq;

    $tmp_buktiPembayaran = $_FILES['bukti_pembayaran']['tmp_name'];

    if($zakatObject->changeStatus($statuszakat, $idreq)){
		if($zakatObject->pendingProses($value_buktiPembayaran, $value_tanggalPembayaran, $value_tahunHijri, $object->getIDzakathist)){
			move_uploaded_file($tmp_buktiPembayaran, $objPath->paymentFitrah_path . $value_buktiPembayaran);
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
if(!$pjesObject->getDetailPJ($object->getIDpj)) die ('error message');

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
</head>
<body>

<h1>Biodata Diri </h1>
<p>Name : <?php echo $data['nama']; ?></p>
<p>Email : <?php echo $data['emails']; ?></p>
<p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
<p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>
<hr>

<h3>Nominal yang harus dibayarkan adalah</h3>
<h2>Rp. <?php echo $zakatObject->data_zakatamount ?></h2>
<p>Zakat yang dibayarkan adalah zakat <b><?php echo $zakatObject->data_zakattype?></b></p>

<hr>
<p>ID Transaksi : <?php echo $object->getIDzakathist ?></p>
<hr>
<h3>Orang Yang Bertanggung Jawab Adalah : <?php echo $pemberiObject->get_nama ?></h3>
<p>Lakukan pembayaran dengaan menggunakan</p>
<h2>BANK <b><?php echo $pjesObject->getDebitCard ?></b></h2>
<h3>No Rek : <b><?php echo $pjesObject->getNoRek ?></b></h3>
<p>1. Transfer nominal ke nomor rekening yang ada diatas ini</p>
<p>2. Setelah transfer selesai foto bukti transfer nya ke form yang sudah disediakan dibawah</p>
<p>3. Klik pada tulisan bayar</p>
<p>4. Tunggu Dikonfirmasi dari penanggung jawabnya</p>
<p>5. Jika masih belum dikonfirmasi, maka bisa menghubungi penanggung jawabnya pada nomor dibawah ini</p>
<p>Nomor Telepon Penanggung Jawab : <b><?php echo $pjesObject->getPhoneNo ?></b></b></p>
<hr>

<h3>Upload Bukti Pembayaran Disini</h3>
<form action="" enctype="multipart/form-data" method="POST">

    <?php
    
    $date = date("Y-m-d");
    $result = $date->format('Y-m-d');

    ?>

    Upload Bukti Pembayaran Disini : <input type="file" name="bukti_pembayaran">
    <input type="hidden" name="tanggal_pembayaran" value="<?php echo $result; ?>">
    <br>
    <br>

    <button type="submit" name="PAY">BAYAR</button>

</form>


    
</body>
</html>