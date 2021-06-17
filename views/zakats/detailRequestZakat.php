<?php
session_start();

if (!isset($_SESSION['user']) || (trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/penerimaQuerys.php');
require_once ('../../queries/users/pjesQuerys.php');
require_once ('../../queries/systems/zakats.php');

$object = new Querys;
$objPath = new Paths;
$data = $object->sessionData($_SESSION['user']);

require_once ('../../funcs/hijriDate.funcs.php');
$hijri = new HijriDate;

$zakatObject = new Zakats;
$penerimaObject = new PenerimaQuerys;
if(!$zakatObject->getDataReq($_GET['id_zakatReq'])) die ('error message');
$pjesObject = new PjesQuerys;
if(!$pjesObject->getIDpj($_SESSION['user'])) die ('error message');

if(isset($_POST['PENDING'])){
	$statuszakat = 'pending';
	$idreq = $zakatObject->data_idzakatreq;
	$idpenrima = $_POST['idpenerima'];

	if($zakatObject->belumToPending($idreq, $pjesObject->getIDpj, $idpenrima)){
		if($zakatObject->changeStatus($statuszakat,$idreq)){
			header('location:../viewsPJ/listRequestZakat.php');
		}else{
			echo "Failed Message 2";
		}
	}else{
		echo "Failed Message 1";
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
</head>
<body>
<!-- Sidebar -->
      <?php include ('../sidebar.views.php') ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
	  	<?php $title = "Confirm Penerima Zakat"; include ('../../header.views.php') ?>
		  <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Pilih Penerima Zakat</h3>
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
                     <tr>
                        <td>Pilih Penerima Zakat </td>
                        <td>
                           <form action="" method="post">:
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
                        </td>
                     </tr>
                  </table>
                  <br>
               </div>
            </div>
         </div>
      </div>	
</body>
</html>