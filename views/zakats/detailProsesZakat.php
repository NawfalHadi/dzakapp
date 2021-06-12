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

    <img src="<?php echo $objPath->paymentFitrah_path.$object->bukti_pembayaran ?>" alt="">
    <hr>

    <h3>Biodata Pemberi</h3>
    <p>Nama : <b><?php echo $pemberiObject->get_nama?></b></p>
    <p>Email : <b><?php echo $pemberiObject->get_emails?></b></p>
    <p>Alamat Lengkap : <b><?php echo $pemberiObject->get_alamatlengkap?></b>
    Rt : <?php echo $pemberiObject->get_rt?> Rw : <?php echo $pemberiObject->get_rw?> Nomor Rumah : <?php echo $pemberiObject->get_nomorrumah?></p>

    <hr>

    <h3>Biodata Penerima</h3>
    <img class='img-penerima' src="<?php echo $objPath->penerima_path.$penerimaOject->foto_penerima ?>" alt="">
    <img class='img-penerima' src="<?php echo $objPath->rumahpenerima_path.$penerimaOject->foto_tempatTinggal ?>" alt=""><br>

    <p>Nama : <?php echo $penerimaOject->nama ?></p>
    <p>Reason : <?php echo $penerimaOject->reason ?></p>
    <p>Kode Pos : <?php echo $penerimaOject->kode_pos ?></p>
    <p>Alamat Lengkap : <?php echo $penerimaOject->alamat_lengkap ?></p>

    <h3>Konfirmasi Pembayarna Dan Pemberian</h3>

    <form action="" enctype="multipart/form-data" method="post">
    
        Bukti Penyerahan : <input type="file" name="bukti_pemberian"><br>
        <button type="submit" name="CONFIRM"> CONFIRM </button>

    </form>
    
</body>
</html>