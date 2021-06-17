<?php 

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/systems/zakats.php');
require_once ('../../queries/users/userQuerys.php');

$object = new Querys;
$zakatObject = new Zakats;
$data = $object->sessionData($_SESSION['user']);
$validating = $object->pj_validateSession($_SESSION['user']);
$objPath = new Paths;

if ($validating == 0) {
	header('location:../../index.php');
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
      <?php include('../sidebar.views.php'); ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
         <?php $title = 'Zakat Fitrah'; include('../../header.views.php') ?>
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
                        <td>: <?php echo $data['alamat_lengkap']; ?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $data['kode_pos']; ?>, Rt <?php echo $data['rt']; ?>, Rw <?php echo $data['rw']; ?></td>
                     </tr>
                  </table>
                  <br><br>
               </div>
            </div>
         </div>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>History Dzakat</h3>
               </header>
               <div class="w3-container">
                  <h3>Pending Pembayaran</h3>
                  <table class="w3-table w3-striped">
                     <tr>
                        <th>Nama</th>
                        <th>Alasan Berhak</th>
                        <th>Zakat</th>
                        <th>Zakat Type</th>
                        <th>Kode Pos</th>
                        <th>Action</th>
                     </tr>
                     <?php 
                         $fitrahReq = $zakatObject->listZakatReq();
                         while($rowFitrah = $fitrahReq->fetch_array()){
                     
                          $biodataObject = new UserQuerys;
                          if(!$biodataObject->getDetailBiodata($rowFitrah['id_biodataPemberi'])) die('Failed Take Data');
                                 
                     ?>
                     <tr>
                        <td><?php echo $biodataObject->get_nama ?></td>
                        <td><?php echo $biodataObject->get_alamatlengkap ?></td>
                        <td>Rp.<?php echo $rowFitrah['zakat_amount']; ?></td>
                        <td><?php echo $rowFitrah['zakat_type']; ?></td>
                        <td><?php echo $biodataObject->get_kode_pos ?></td>
                        <td>
                        <a href="<?php echo "../zakats/detailRequestZakat.php?id_zakatReq=". $rowFitrah['id_zakatReq'];?>" class="w3-button w3-green">Accept</a>
                        </td>
                     </tr>
                     <?php } ?>
                  </table>
                  <br><br>
                  <h3>Pembayaran yang sedang diproses</h3>
                  <table class="w3-table w3-striped">
                     <tr>
                        <th>Nama</th>
                        <th>Alasan Berhak</th>
                        <th>Zakat</th>
                        <th>Zakat Type</th>
                        <th>Kode Pos</th>
                        <th>Action</th>
                     </tr>
                     <?php 
                         $fitrahReq = $zakatObject->listZakatProses();
                         while($rowFitrah = $fitrahReq->fetch_array()){
                     
                          $biodataObject = new UserQuerys;
                          if(!$biodataObject->getDetailBiodata($rowFitrah['id_biodataPemberi'])) die('Failed Take Data');
                                 
                     ?>
                     <tr>
                        <td><?php echo $biodataObject->get_nama ?></td>
                        <td><?php echo $biodataObject->get_alamatlengkap ?></td>
                        <td>Rp.<?php echo $rowFitrah['zakat_amount']; ?></td>
                        <td><?php echo $rowFitrah['zakat_type']; ?></td>
                        <td><?php echo $biodataObject->get_kode_pos ?></td>
                        <td>
                        <a href="<?php echo "../zakats/detailProsesZakat.php?id_zakatReq=". $rowFitrah['id_zakatReq'];?>" class="w3-button w3-green">Confirm</a>
                        </td>
                     </tr>
                     <?php } ?>
                  </table>
                  <br>
               </div>
            </div>
         </div>
         <br><br>
      </div>
</body>
</html>