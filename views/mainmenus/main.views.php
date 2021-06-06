<?php

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');

$object = new Querys;

$data = $object->sessionData($_SESSION['user']);
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

    <a href="">Zakat Fitrah</a><br>
    <a href="">Zakat Mal</a><br><br>

    <?php echo $data['nama']; ?>| <a href="../accounts/profiles.views.php">Profile</a><br>
    <a href="../../funcs/logoutFuncs.funcs.php" class="btn btn-danger">Logout</a>
    
</body>
</html>