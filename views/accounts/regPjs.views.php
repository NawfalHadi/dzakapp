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
    $status = $_POST['status'];
    $ktpoto = $_FILES['ktp_foto']['name'];
    $ktpuser = $_FILES['ktp_and_user']['name'];
    $phone = $_POST['phone'];
    $cardbit = $_POST['debit_card'];
    $norek = $_POST['no_rek'];

    $filetmp1 = $_FILES['ktp_foto']['tmp_name'];
    $filetmp2 = $_FILES['ktp_and_user']['tmp_name'];

    if ($Obj->requestPJ($id_bio, $status, $ktpoto, $ktpuser, $phone, $cardbit, $norek)):
        echo "<p>succes message</p>";
        move_uploaded_file($filetmp1, $objPath->ktp_path . $ktpoto);
        move_uploaded_file($filetmp2, $objPath->ktpUser_path . $ktpuser);
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
</head>
<body>

<h1>Register Untuk Menjadi PJ ? | <?php echo $data['nama']; ?></h1>
<p>Name : <?php echo $data['nama']; ?></p>
<p>Email : <?php echo $data['emails']; ?></p>
<p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
<p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>

<br>

<form action="" method="post" enctype="multipart/form-data">
    <p>Your ID is : <?php echo $data['id_biodata']; ?></p> <input type="hidden" name="id_biodata" value="<?php echo $data['id_biodata']; ?>">
    <p>Note : Status mu akan tidak aktif, sampai di ACC setelah melihat laporan mu, terima kasih</p> <input type="hidden" name="status" value="0">

    <input type="file" name="ktp_foto"><br><br>
    <input type="file" name="ktp_and_user"><br><br>
    <input type="text" name="phone"><br><br>
    <input type="text" name="debit_card"><br><br>
    <input type="text" name="no_rek"><br><br>

    <button type="submit" name="REQ">Request</button>
</form>
    
</body>
</html>