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

$data = $object->sessionData($_SESSION['user']);

$Obj = new PjesQuerys;
$objPath = new Paths;

if (isset($_POST['REQ'])):
    $id_bio = $_POST['id_biodata'];
    $status = 0;
    $ktpoto = $_FILES['ktp_foto']['name'];
    $ktpuser = $_FILES['ktp_and_user']['name'];
    $phone = $_POST['phone'];
    $cardbit = $_POST['debit_card'];
    $norek = $_POST['no_rek'];

    $filetmp1 = $_FILES['ktp_foto']['tmp_name'];
    $filetmp2 = $_FILES['ktp_and_user']['tmp_name'];

    if ($Obj->requestPJ($id_bio, $status, $ktpoto, $ktpuser, $phone, $cardbit, $norek)):
        move_uploaded_file($filetmp1, $objPath->ktp_path . $ktpoto);
        move_uploaded_file($filetmp2, $objPath->ktpUser_path . $ktpuser);
        header('location:profiles.views.php');
    else:
        null;
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
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
   <!-- Core theme CSS (includes Bootstrap)-->
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<!-- Sidebar -->
      <?php include ('../sidebar.views.php'); ?>
      <!-- Page Content -->
      <div style="margin-left:2.8%">
        <?php $title = "Daftar Jadi PJ"; include ('../../header.views.php'); ?>
        <div class="w3-container" style="margin-left: 35px; margin-top: 25px; margin-right: 40px",>
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
               </div>
            </div>
         </div>
         <div class="w3-container" style="margin-left: 35px; margin-top: 25px; margin-right: 40px",>
            <div class="w3-card-4" style="border-radius: 10px;">
                     <br>
                     <form class="w3-container" action="" method="POST" enctype="multipart/form-data">
                        <label>ID</label>
                        <input type="text" name="id_biodata" value="<?php echo $data['id_biodata']; ?>" readonly class="w3-input w3-border">
                        <p style="font-size: 10px; color: grey">*Status mu akan tidak aktif, sampai di ACC setelah melihat laporan mu, terima kasih</p>

                        <label>KTP</label>
                        <input type="file" name="ktp_foto" class="w3-input w3-border">

                        <label>FOTO Ktp Dengan Anda</label>
                        <input type="file" name="ktp_and_user"class="w3-input w3-border">

                        <label>NO HP</label>
                        <input type="text" name="phone" class="w3-input w3-border">

                        <label>Kartu Debit</label>
                        <input type="text" name="debit_card" class="w3-input w3-border">

                        <label>NO Rekening</label>
                        <input type="text" name="no_rek" class="w3-input w3-border">

                        <button class="w3-btn w3-blue w3-section w3-padding" type="submit" name="REQ">Daftar</button>
                     </form>
                  </div>
                  <br>
            </div> 
         </div>
      </div>
   </body>
</body>
</html>