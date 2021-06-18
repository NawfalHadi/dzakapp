<?php

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/incomes.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/systems/converts.php');
require_once ('../../queries/systems/zakats.php');
require_once ('../../queries/users/userQuerys.php');

$object = new Querys;
$data = $object->sessionData($_SESSION['user']);

$goldObject = new Converts;
if(!$goldObject->useGold()) die ('eror lmao');

$message = null;

$biodataObject = new UserQuerys;
$incomeObject = new Incomes;
if(!$incomeObject->detailIncomes($data['id_biodata'])) die ('error message');

$zakatObject = new Zakats;

if(isset($_POST['new'])){
    $nomins = $_POST['nominal'];
    if($goldObject->updateGold($nomins)){
        header('location:emasPrice.views.php');
        $message = "Gold Updated";
    }else {
        $message = "Error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Document</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!-- Sidebar -->
      <?php include('../sidebar.views.php') ?>
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
                        <td>: <?php echo $data['alamat_lengkap']; ?>, Rt <?php echo $data['rt']; ?>, Rw <?php echo $data['rw']; ?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $data['kode_pos']; ?></td>
                     </tr>
                  </table>
                  <br>
               </div>
            </div>
         </div>
         <div class="w3-container" style="margin-left: 10px; margin-top: 25px;",>
            <div class="w3-card-4" style="border-radius: 10px;">
               <header class="w3-container w3-light-grey">
                  <h3>Setting Harga Emas</h3>
               </header>
               <div class="w3-container">            
                  <form action="" method="post">
                  <br>
                    <?php echo $message; ?>
                    Harga Emas : <input type="number" name="nominal" value="<?php echo $goldObject->nominal ?>">  /gr <br> <br> <button type="submit" name="new">UPDATE</button>
                  </form>
                  <br>
               </div>
            </div>
         </div>
      </div>
</body>
</html>