<?php 

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/zakats/fitrahQuerys.php');
require_once ('../../queries/users/pjesQuerys.php');

$object = new Querys;
$data = $object->sessionData($_SESSION['user']);
$objPath = new Paths;

require_once ('../../funcs/hijriDate.funcs.php');
$hijri = new HijriDate;

$fitrahObject = new FitrahQuerys;
$pjesObject = new PjesQuerys;

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

<h1>Biodata </h1>
<p>Name : <?php echo $data['nama']; ?></p>
<p>Email : <?php echo $data['emails']; ?></p>
<p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
<p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>
<hr>

<?php 

    $pjes = $pjesObject->listPJActive();
    while($rowPjes = $pjes->fetch_array()){

        $biodataPjes = $object->sessionData($rowPjes['id_biodata']); 
        echo $biodataPjes['nama'];
        echo '<hr>';

    }

?>
    
</body>
</html>