<?php 

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/penerimaQuerys.php');

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

$object = new Querys;
$penerimaObject = new PenerimaQuerys;
$data = $object->sessionData($_SESSION['user']);
$validating = $object->pj_validateSession($_SESSION['user']);
$objPath = new Paths;

if ($validating == 0) {
	header('location:../../index.php');
}

if(!$penerimaObject->getDataPenerima($_GET['id_penerima'])) die ('error message');

if (isset($_POST['HAPUS'])):

    if ($penerimaObject->deleteDataPenerima($penerimaObject->id_penerima)):
        echo "<p>succes message</p>";
	    header('location:listPenerima.views.php');
    else:
        echo "<p>error message</p>";
    endif;
endif;

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
                  <h3>Detail Penerima</h3>
               </header>
                <div class="w3-container">
                  <br>
                  <table class="w3-table w3-bordered">
                     <tr>
                        <td>Nama </td>
                        <td>: <?php echo $data['nama']; ?></td>
                     </tr>
                     <tr>
                        <td>Alamat Lengkap </td>
                        <td>: <?php echo $data['alamat_lengkap']; ?>, Rt <?php echo $data['rt']; ?>, Rw <?php echo $data['rw']; ?></td>
                     </tr>
                     <tr>
                        <td>Kode Pos </td>
                        <td>: <?php echo $data['kode_pos']; ?></td>
                     </tr>
                     <tr>
                        <td>Foto Penerima </td>
                        <td>: <img src="<?php echo $objPath->penerima_path . $penerimaObject->foto_penerima ?>" alt="LMAO"></td>
                     </tr>
                     <tr>
                        <td>Foto Tempat Tinggal </td>
                        <td>: <img src="<?php echo $objPath->rumahpenerima_path . $penerimaObject->foto_tempatTinggal ?>" alt="LMAO"></td>
                     </tr>
                  </table>
                  <br>
                  <form action="" method="post">
                  <a href="<?php echo "editPenerima.views.php?id_penerima=". $penerimaObject->id_penerima?>" class="w3-button w3-blue"><i class="fa fa-edit"></i> Edit Biodata</a>
                  <button type="submit" name="HAPUS" class="w3-button w3-red"><i class="fa fa-remove"></i> Hapus Data Penerima</button>
                  </form>
                  <br><br>
               </div>
            </div>
        </div>
        <br><br>
    </div>
</body>
</html>