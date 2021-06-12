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
$zakatObject = new Zakats;
$data = $object->sessionData($_SESSION['user']);
$validating = $object->pj_validateSession($_SESSION['user']);
$objPath = new Paths;

if ($validating == 0) {
	header('location:../../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    
    table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        img {
            width: 80px;
        }
    
    </style>
</head>
<body>

<!-- Disini -->

<table>
  <tr>
    <th>Nama</th>
    <th>Alamat Lengkap</th>
    <th>Zakat</th>
    <th>Zakat Type</th>
    <th>Kode Pos</th>
    <th>Action</th>
  </tr>

<?php 
    $fitrahReq = $zakatObject->listZakatReq();
    while($rowFitrah = $fitrahReq->fetch_array()){

        $getBiodata = $object->sessionData($rowFitrah['id_biodataPemberi']);
        if($getBiodata['kode_pos'] == $object->sessionData($data['id_biodata'])['kode_pos']){
            
?>
  <tr>
    <td><?php echo $getBiodata['nama']; ?></td>
    <td><?php echo $getBiodata['alamat_lengkap']; ?></td>
    <td>Rp.<?php echo $rowFitrah['zakat_amount']; ?></td>
    <td><?php echo $rowFitrah['zakat_type']; ?></td>
    <td><?php echo $getBiodata['kode_pos']; ?></td>
    <td><a href="<?php echo "../zakats/detailRequestZakat.php?id_zakatReq=". $rowFitrah['id_zakatReq'];?>">Detail</a></td>
  </tr>

<?php
        }else {
            // null
        }
    }
?>
    
</table>

<h3>Pembayaran Yang Menunggu Di Proses</h3>

<table>
  <tr>
    <th>Nama</th>
    <th>Alamat Lengkap</th>
    <th>Zakat</th>
    <th>Zakat Type</th>
    <th>Kode Pos</th>
    <th>Action</th>
  </tr>

<?php 
    $fitrahReq = $zakatObject->listZakatProses();
    while($rowFitrah = $fitrahReq->fetch_array()){

        $getBiodata = $object->sessionData($rowFitrah['id_biodataPemberi']);
        if($getBiodata['kode_pos'] == $object->sessionData($data['id_biodata'])['kode_pos']){
            
?>
  <tr>
    <td><?php echo $getBiodata['nama']; ?></td>
    <td><?php echo $getBiodata['alamat_lengkap']; ?></td>
    <td>Rp.<?php echo $rowFitrah['zakat_amount']; ?></td>
    <td><?php echo $rowFitrah['zakat_type']; ?></td>
    <td><?php echo $getBiodata['kode_pos']; ?></td>
    <td><a href="<?php echo "../zakats/detailProsesZakat.php?id_zakatReq=". $rowFitrah['id_zakatReq'];?>">Detail</a></td>
  </tr>

<?php
        }else {
            // null
        }
    }
?>
    
</table>
    
</body>
</html>