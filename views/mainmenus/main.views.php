<?php

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
    header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/pjesQuerys.php');

$object = new Querys;
$pjesObject = new PjesQuerys;
$validating = $object->pj_validateSession($_SESSION['user']);

if ($validating != 0) {
	header('location:mainPJ.views.php');
}

$data = $object->sessionData($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>Dzakapp - Main Page</title>
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
      <div style="margin-left:2.8%">
        <?php
            $title = "Halaman Utama";
            include ('../../header.views.php');
        ?>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <div class="w3-container">
                  <h2>Quick Access</h2>
               </div>
               <div class="w3-container">
                  <a href="#">Zakat Fitrah</a><br>
                  <a href="#">Zakat Mal</a><br><br>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>