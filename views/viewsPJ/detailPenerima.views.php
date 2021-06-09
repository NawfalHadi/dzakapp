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

    <style>
    
    img {
            width: 80px;
        }

    </style>

</head>
<body>

<h1>Biodata Admin</h1>

<p>Name : <?php echo $data['nama']; ?></p>
<p>Email : <?php echo $data['emails']; ?></p>
<p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
<p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>

<hr>

<h1>Biodata Penerima</h1><a href="<?php echo "editPenerima.views.php?id_penerima=". $penerimaObject->id_penerima?>">Edit Biodata</a><br>
Foto Penerima : <img src="<?php echo $objPath->penerima_path . $penerimaObject->foto_penerima ?>" alt="LMAO">
<br>
Foto Tempat Tinggal : <img src="<?php echo $objPath->rumahpenerima_path . $penerimaObject->foto_tempatTinggal ?>" alt="LMAO">

<p>Nama : <?php echo $penerimaObject->nama ?> </p>
<p>Alamat Lengkap : <?php echo $penerimaObject->alamat_lengkap ?></p>
<p>Kode Pos : <?php echo $penerimaObject->kode_pos ?></p>

<form action="" method="post">
    <button name="HAPUS" type="submit">Delete</button>
</form>
</body>
</html>