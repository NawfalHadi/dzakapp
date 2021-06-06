<!-- Disini kamu taroh welcome aja, taruh hadits gitu -->
<?php 

    session_start();

    if(isset($_SESSION['user'])){
		header('location:views/mainmenus/main.views.php');
	}

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

<h1>Login Page</h1>

<form method="post" action="funcs/loginFuncs.funcs.php">
    <input type="text" name="emails" placeholder="emails"><br><br>
    <input type="password" name="pass" placeholder="password"><br><br>

    <button type="submit" name="login">LOGIN</button>
</form>

<?php 
if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
    
</body>
</html>