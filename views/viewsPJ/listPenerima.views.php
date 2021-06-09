<?php 

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/users/penerimaQuerys.php');

$object = new Querys;
$penerimaObject = new PenerimaQuerys;
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
    
    
<h1>Biodata | <?php echo $data['nama']; ?></h1>
<p>Name : <?php echo $data['nama']; ?></p>
<p>Email : <?php echo $data['emails']; ?></p>
<p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
<p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>

<br>

<a href="createPenerima.views.php">Tambah Data Penerima</a>

<table>
  <tr>
    <th>Nama</th>
    <th>Alasan Berhak</th>
    <th>Alamat Lengkap</th>
    <th>Kode Pos</th>
    <th>Foto Penerima</th>
    <th>Foto Tempat Tinggal</th>
    <th>Action</th>
  </tr>

<?php 
    $penerima = $penerimaObject->listDataPenerima();
    while($rowPenerima = $penerima->fetch_array()){
?>

  <tr>
    <td><?php echo $rowPenerima['nama']; ?></td>
    <td><?php echo $rowPenerima['reason']; ?></td>
    <td><?php echo $rowPenerima['alamat_lengkap']; ?></td>
    <td><?php echo $rowPenerima['kode_pos']; ?></td>
    <td><img src="<?php echo "$objPath->penerima_path".$rowPenerima['foto_penerima']; ?>"></td>
    <td><img src="<?php echo "$objPath->rumahpenerima_path".$rowPenerima['foto_tempatTinggal']; ?>"></td>
    <td>
        <a href="<?php echo "detailPenerima.views.php?id_penerima=". $rowPenerima['id_penerima'];?>">Detail</a>
    </td>
  </tr>

<?php 
    }
?>
    
</table>


</body>
</html>