<?php

session_start();

if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:../../index.php');
}

require_once ('../../databases/databases.db.php');
require_once ('../../queries/systems/querys.php');
require_once ('../../queries/systems/incomes.php');
require_once ('../../queries/systems/paths.php');
require_once ('../../queries/systems/zakats.php');
require_once ('../../queries/users/userQuerys.php');

$object = new Querys;
$data = $object->sessionData($_SESSION['user']);

$message = null;

$biodataObject = new UserQuerys;
$incomeObject = new Incomes;
if(!$incomeObject->detailIncomes($data['id_biodata'])) die ('error message');

$zakatObject = new Zakats;

if (isset($_POST['REQ'])):
    $mal = $incomeObject->calculateZakatMal($incomeObject->get_emasamount);
    if ($zakatObject->reqZakat($data['id_biodata'], "Mal",  $mal)):
        echo "<p>succes message</p>";
        header('location:mainMal.views.php');
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

<form action="" method="post">
    <p>Zakat yang akan kamu keluarkan dari <?php echo $incomeObject->get_emasamount ?> gram emas mu adalah <b><?php echo $incomeObject->calculateZakatMal($incomeObject->get_emasamount) ?></b> gram</p>
    <button type="submit" name="REQ"> PAY ZAKAT MAL </button>
</form>
    
</body>
</html>