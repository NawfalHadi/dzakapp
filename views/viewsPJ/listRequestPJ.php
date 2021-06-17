<?php 

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/penerimaQuerys.php');
require_once ('../../queries/users/pjesQuerys.php');
require_once ('../../queries/users/userQuerys.php');

$object = new Querys;
$pjesObject = new pjesQuerys;
$data = $object->sessionData($_SESSION['user']);
$validating = $object->pj_validateSession($_SESSION['user']);
$objPath = new Paths;

if ($validating == 0) {
	header('location:../../index.php');
}

// if(isset($_POST['Active'])){
//     if();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
    <!-- Favicon-->
   <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
   <!-- Core theme CSS (includes Bootstrap)-->
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
 <!-- Sidebar -->
      <?php include('../sidebar.views.php'); ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
      <?php $title = "List Data Penerima"; include('../../header.views.php'); ?>
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
                  <h3>List PJ Tidak Active
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-striped">
                     <tr>
                        <th>Nama</th>
                        <th>Emails</th>
                        <th>Alamat Lengkap</th>
                        <th>Kode Pos</th>
                        <th>Action</th> 
                     </tr>
                     <?php 
                         $pjes = $pjesObject->listPJNotActive();
                         while($rowPjes = $pjes->fetch_array()){
                            
                            $biodataObject = new UserQuerys;
                            if(!$biodataObject->getDetailBiodata($rowPjes['id_biodata'])) die ("can't get biodata")
                     ?>
                     <tr>
                        <td><?php echo $biodataObject->get_nama ?></td>
                        <td><?php echo $biodataObject->get_emails ?></td>
                        <td><?php echo $biodataObject->get_alamatlengkap ?></td>
                        <td><?php echo $biodataObject->get_kode_pos ?></td>
                        <td>
                        <a href="<?php echo "detailPjes.views.php?id_pj=". $rowPjes['id_pj'];?>" style="margin-left: 25px;" data-toogle="tooltip" title="Detail Pjes">
                           <i class="fa fa-info"></i>
                        </a>
                        </td>
                     </tr>
                     <?php 
                         }
                     ?>
                  </table>
                  <br>
               </div>
            </div>
         </div>
      </div>
</body>
</html>