<?php

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');

$object = new Querys;

$data = $object->sessionData($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>Dzakapp - Profile</title>
      <!-- Favicon-->
      <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
      <!-- Core theme CSS (includes Bootstrap)-->
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
      <!-- Sidebar -->
      <?php
      
      include ('../sidebar.views.php');

      ?>
      <!-- Page Content -->
      <div style="margin-left:4%">
        <?php
            $title = "Halaman Profil";
            include ('../../header.views.php');
        ?>
         <div class="w3-container" style="margin-left: 35px; margin-top: 25px;",>
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
                        <td>: <?php echo $data['kode_pos']; ?>, Rt <?php echo $data['rt']; ?>, Rw <?php echo $data['rw'];?></td>
                     </tr>
                  </table>
                  <br>
                  <a href="#" class="w3-button w3-blue">Register Menjadi Penanggung Jawab</a>
                  <a href="<?php echo 'setting.incomes.php' ?>" class="w3-button w3-blue">Penghasilan</a>
                  <br><br>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>