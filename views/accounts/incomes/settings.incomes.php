<?php
$today = date_create(date("Y-m-d"));
$datepplus = date_add($today, date_interval_create_from_date_string("365 days"));
session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../../databases/databases.db.php');
require_once ('../../../queries/systems/querys.php');
require_once ('../../../queries/systems/incomes.php');
require_once ('../../../queries/users/userQuerys.php');

$object = new Querys;
$data = $object->sessionData($_SESSION['user']);

$message = null;

$biodataObject = new UserQuerys;
$incomeObject = new Incomes;


if(isset($_POST['MAKE'])){
    $idbio = $data['id_biodata'];
    $gold = $_POST['emas_amount'];
    $datepay = date_format($datepplus, "Y-m-d");

    if($gold < 85){
        if($incomeObject->addIncomes($idbio, $gold, null)){
            header("Refresh:0; url=settings.incomes.php");
            $message = "Setting Completed, Emas mu belum sampai nishab yaitu 85g emas";
        }else {
            $message = "Something Wrong 1";
        }
    }else {
        if($incomeObject->addIncomes($idbio, $gold, $datepay)){
            $message = "Setting Completed, Kamu akan ditagih setahun kemudian jika masih mempunyai harta diatas nishab";
        }else {
            $message = "Something Wrong 2";
        }
    }
}

if(isset($_POST['UPDATES'])){
    $idbio = $data['id_biodata'];
    $gold = $_POST['emas_amount'];
    $datepay = date_format($datepplus, "Y-m-d");

    if($gold < 85){
        if($incomeObject->editIncomes($gold, null, $idbio)){
            $message = "Setting Completed, Emas mu belum sampai nishab yaitu 85g emas";
        }else {
            $message = "Something Wrong 1";
        }
    }else {
        if(!$incomeObject->detailIncomes($data['id_biodata'])) die ('error message');
        if($incomeObject->get_datepay != null){
            if($incomeObject->editIncomes($gold, $incomeObject->get_datepay, $idbio)){
                $message = "Setting Completed, Kamu akan ditagih setahun kemudian jika masih mempunyai harta diatas nishab";
            }else {
                $message = "Something Wrong 2";
            }
        }else{
            if($incomeObject->editIncomes($gold, $datepay, $idbio)){
                $message = "Setting Completed, Kamu akan ditagih setahun kemudian jika masih mempunyai harta diatas nishab";
            }else {
                $message = "Something Wrong 2";
            }
        }
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
      <div class="w3-sidebar w3-light-grey w3-bar-block" style="width:2.8%">
         <div class="w3-container w3-light-grey w3-bar-item">
            <h1>.</h1>
         </div>
         <a href="../../mainmenus/main.views.php" class="w3-bar-item w3-button"><i class="fa fa-home" aria-hidden="true"></i></a>
         <a href="../profiles.views.php" class="w3-bar-item w3-button"><i class="fa fa-user" aria-hidden="true"></i></a>
      </div>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
         <?php $title = 'Harta'; include('../../../header.views.php'); ?>
         <div class="w3-container">
            <div class="w3-card-4" style="margin-top: 10px">
               <header class="w3-container w3-light-grey">
                  <h3>Biodata saia</h3>
               </header>
               <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>ID Biodata </td>
                        <td>: <?php echo $data['id_biodata']; ?></td>
                     </tr>
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
         <div class="w3-container">
            <div class="w3-card-4" style="margin-top: 10px">
               <header class="w3-container w3-light-grey">
                  <h3>Pendapatan</h3>
               </header>
               <div class="w3-container">
                  <br>
                  <?php if($biodataObject->checkIncomes($data['id_biodata']) == 0){ ?>
                  <h3>Isi Jumlah Emas Yang anda punya</h3>
                  <form action="" method="post">
                     Emas yang dipunya : <input type="number" name="emas_amount">gr
                     <br><br>
                     <button type="submit" name="MAKE"> INPUT HARTA</button>
                  </form>
                  <?php }else{ if(!$incomeObject->detailIncomes($data['id_biodata'])) die ('error message');  ?> 
                  <h3>Harta Anda</h3>
                  <?php if($message == null) { null; } else { echo 'Message : '.$message; } ?>
                  <form action="" method="post">
                     <input type="hidden" name="date_pay" value="<?php echo $incomeObject->get_datepay ?>">
                     <input type="number" name="emas_amount" value="<?php echo $incomeObject->get_emasamount ?>"> gr 
                     <button type="submit" name="UPDATES">UPDATE</button>
                  </form>
                  <?php 
                     if ($incomeObject->get_datepay != null){
                         $daysleft = date_diff(date_create(date("Y-m-d")), date_create($incomeObject->get_datepay));
                     
                         if($daysleft->format("%R") == "-"){
                             echo "<p>How many days left to pay : Saatnya membayar zakat mal | <a href=''>You Can Pay Your Zakat Mal Here</a></p> ";
                         }else {
                             echo "<p>How many days left to pay : ". $daysleft->format('%a Days Left') ." </p> ";
                         }
                     }else {
                         echo "<p>Masih belum sampai nishab yaitu 85 gram emas</p> ";
                     }
                     
                     
                     ?>
                  <?php } ?>
                  <br><br>
               </div>
            </div>
         </div>
      </div>
</body>
</html>