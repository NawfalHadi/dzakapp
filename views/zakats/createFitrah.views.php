<?php 

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/systems/zakats.php');


$object = new Querys;
$objPath = new Paths;
$data = $object->sessionData($_SESSION['user']);

require_once ('../../funcs/hijriDate.funcs.php');
$hijri = new HijriDate;

$fitrahObject = new Zakats;

if (isset($_POST['PAY'])):

    if ($fitrahObject->reqZakat($data['id_biodata'], "Fitrah", "40000" )):
        echo "<p>succes message</p>";
        header('location:paymentFitrah.views.php');
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
    
    <h1>Biodata Anda</h1>
    <p>Name : <?php echo $data['nama']; ?></p>
    <p>Email : <?php echo $data['emails']; ?></p>
    <p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
    <p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>

    <hr>

    <h1>Pembayaran Zakat Fitrah</h1>
    <form action="" method="post">

        <p>Zakat fitrah harus dibayarkan tiap jiwa dengan menggunakan beras 3,5 Liter</p>
        <p>Atau dengan menggunakan uang sebeser <b>Rp.40.000</b></p>
        
        <button type="submit" name="PAY">Bayar Zakat Fitrah</button>
    </form>

    <hr>

</body>
</html>