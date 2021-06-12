<?php
session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/penerimaQuerys.php');
require_once ('../../queries/systems/zakats.php');

$object = new Querys;
$objPath = new Paths;
$data = $object->sessionData($_SESSION['user']);

require_once ('../../funcs/hijriDate.funcs.php');
$hijri = new HijriDate;

$zakatObject = new Zakats;
$penerimaObject = new PenerimaQuerys;

if(!$zakatObject->getDataReq($_GET['id_zakatReq'])) die ('error message');

if(isset($_POST['PENDING'])){
	$statuszakat = 'pending';
	$idreq = $zakatObject->data_idzakatreq;
	$idpenrima = $_POST['idpenerima'];

	if($zakatObject->changeStatus($statuszakat,$idreq)){
		if($zakatObject->belumToPending($idreq, $_SESSION['user'], $idpenrima)){
			echo "succes Message";
		}else{
			echo "Failed Message";
		}
	}else{

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
</head>
<body>

<h3>Biodata Saya</h3>
<p>Name : <?php echo $data['nama']; ?></p>
<p>Email : <?php echo $data['emails']; ?></p>
<p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
<p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>	
<hr>


<form action="" method="post">
	<select name="idpenerima" id="cars">
	<?php 
		$penerima = $penerimaObject->penerimaTerdekatPJ($object->sessionData($data['id_biodata'])['kode_pos']);
    	while($rowPenerima = $penerima->fetch_array()){
	?>
    	<option value="<?php echo $rowPenerima['id_penerima'] ?>"><?php echo $rowPenerima['nama'] ?></option>

	<?php } ?>
  	</select>

	<button type="submit" name="PENDING">CONFIRM</button>

</form>
	
</body>
</html>