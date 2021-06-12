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

$zakatObject = new Zakats;
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
            width: 100px;
        }
    </style>
</head>
<body>

<h1>Biodata | <?php echo $data['nama']; ?></h1>
<p>Name : <?php echo $data['nama']; ?></p>
<p>Email : <?php echo $data['emails']; ?></p>
<p>Alamat Lengkap: <?php echo $data['alamat_lengkap']; ?></p>
<p>Kode Pos : <?php echo $data['kode_pos']; ?>, Rt : <?php echo $data['rt']; ?>, Rw: <?php echo $data['rw']; ?></p>

<hr>

<h3><?php echo $hijri->get_year(); ?></h3>

<?php 
if($hijri->get_month() == $hijri->get_month_name(9)):
    echo '<a href="createFitrah.views.php">Pay Zakat Fitrah</a>';
else:
?>
    <p>Belum waktunya untuk melakukan pembayaran zakat fitrah</p>
<?php
endif;
echo '<a href="createFitrah.views.php">Pay Zakat Fitrah</a>';

?>

<hr>

<h1>History Dzakat</h1>
<h3>Pending Pembayaran</h3>

<table>
  <tr>
    <th>Nama</th>
    <th>Alasan Berhak</th>
    <th>Zakat</th>
    <th>Zakat Type</th>
    <th>Kode Pos</th>
    <th>Action</th>
  </tr>

<?php 
    $fitrahReq = $zakatObject->listZakatPending();
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
    <td><a href="<?php echo "paymentFitrah.views.php?id_zakatReq=". $rowFitrah['id_zakatReq'];?>">Bayar</a></td>
  </tr>

<?php
        }else {
            // null
        }
    }
?>
    
</table>

<hr>
<h3>History Pembayaran</h3>

<table>
  <tr>
    <th>Nama</th>
    <th>Alasan Berhak</th>
    <th>Zakat</th>
    <th>Zakat Type</th>
    <th>Kode Pos</th>
    <th>Action</th>
  </tr>

<?php 
    $fitrahReq = $zakatObject->listZakatLunas();
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
    <td><a href="">Detail</a></td>
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