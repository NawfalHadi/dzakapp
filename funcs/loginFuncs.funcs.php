<?php

    session_start();

    require_once ('../databases/databases.db.php');
    require_once ('../queries/systems/querys.php');

    $db = new Databases;
    $qry = new Querys;


    if(isset($_POST['login'])) {
        $emails = $db->escape_string($_POST['emails']);
        $pass = $db->escape_string($_POST['pass']);

        $auth = $qry->logins($emails, $pass);

        if(!$auth){
            $_SESSION['message'] = 'Check Your Username Or Password';
            header('location:../index.php');
        }else{
            $_SESSION['user'] = $auth;
            header('location:../views/mainmenus/main.views.php');
        }
    } else {
        $_SESSION['message'] = 'You need to login first';
        header('location:index.php');
    }

?>