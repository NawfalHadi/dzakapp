<?php 

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/userQuerys.php');
require_once ('../../queries/users/pjesQuerys.php');

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

$object = new Querys;
$data = $object->sessionData($_SESSION['user']);
$validating = $object->pj_validateSession($_SESSION['user']);
$objPath = new Paths;

$pjesObject = new PjesQuerys;
$biodataObject = new UserQuerys;

if(!$pjesObject->getDetailPJ($_GET['id_pj'])) die ('erro getting detail PJ');
if(!$biodataObject->getDetailBiodata($pjesObject->getIDbiodata)) die ('error getting detail biodata');

if ($validating == 0) {
	header('location:../../index.php');
}

if (isset($_POST['TERIMA'])){
    if($pjesObject->terimaPj($pjesObject->getIDpj)){
        header("location:listRequestPJ.php");
    }
}elseif (isset($_POST['TOLAK'])){
    if($pjesObject->tolakPj($pjesObject->getIDpj)){
        header("location:listRequestPJ.php");
    }    
}

// if (isset($_POST['HAPUS'])):

//     if ($pemberiObject->deleteDataPenerima($pemberiObject->id_penerima)):
//         echo "<p>succes message</p>";
// 	    header('location:listPenerima.views.php');
//     else:
//         echo "<p>error message</p>";
//     endif;
// endif;

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
            width: 80px;
        }

    </style>

</head>
<body>
<!-- Sidebar -->
      <?php include ('../sidebar.views.php'); ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
        <?php $title = 'Data Penerima';include ('../../header.views.php'); ?>
        <div class="w3-container" style="margin-left: 35px; margin-top: 25px; margin-right: 40px">
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Profile Admin</h3>
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
                        <td>: <?php echo $data['kode_pos']; ?>, Rt <?php echo $data['rt']; ?>, Rw <?php echo $data['rw']; ?></td>
                     </tr>
                  </table>
                  <br>
               </div>
            </div>
         </div>
         <div class="w3-container" style="margin-left: 35px; margin-top: 25px; margin-right: 40px">
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Detail PJ Yang Mendaftar</h3>
               </header>
                <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Nama </td>
                        <td>: <?php echo $biodataObject->get_nama ?></td>
                     </tr>
                     <tr>
                        <td>Alamat Lengkap </td>
                        <td>: <?php echo $biodataObject->get_alamatlengkap ?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $biodataObject->get_kode_pos ?></td>
                     </tr>
                     <tr>
                        <td>Phone No </td>
                        <td>: <?php echo $pjesObject->getPhoneNo ?></td>
                     </tr>
                     <tr>
                        <td>Debit Card </td>
                        <td>: <?php echo $pjesObject->getDebitCard ?></td>
                     </tr>
                     <tr>
                        <td>No Rekening </td>
                        <td>: <?php echo $pjesObject->getNoRek ?></td>
                     </tr>
                     <tr>
                        <td>Ktp </td>
                        <td>: <img src="<?php echo $objPath->ktp_path . $pjesObject->getKtpFoto ?>" alt="LMAO"></td>
                     </tr>
                     <tr>
                        <td>User Dan Ktp </td>
                        <td>: <img src="<?php echo $objPath->ktpUser_path . $pjesObject->getKtpAndUser ?>" alt="LMAO"></td>
                     </tr>
                  </table>
                  <br>
                  <form action="" method="post">
                  <button type="submit" name="TERIMA" class="w3-button w3-green"><i class="fa fa-check"></i> Terima Pendaftaran</button>
                  <button type="submit" name="TOLAK" class="w3-button w3-red"><i class="fa fa-remove"></i> Tolak Pendaftaran</button>
                  </form>
                  <br><br>
               </div>
            </div>
        </div>
        <br><br>
    </div>
</body>
</html>