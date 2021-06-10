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
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>Dzakapp - Login Page</title>
      <!-- Favicon-->
      <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
      <!-- Core theme CSS (includes Bootstrap)-->
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   </head>
   <body>
      <center>
         <div class="w3-card-4" style="max-width:600px; margin-top: 80px">
            <br>
            <h1>DzakApp</h1>
            <form class="w3-container" action="funcs/loginFuncs.funcs.php" method="post">
               <div class="w3-section">
                  <label><b>Email</b></label><br><br>
                  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Email" name="emails" required>
                  <label><b>Password</b></label><br><br>
                  <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="pass" required>
                  <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit" name="login">Login</button>
               </div>
            </form>
         </div>
         <br>
         <?php 
            if(isset($_SESSION['message'])){
               echo $_SESSION['message'];
               unset($_SESSION['message']);
            }
         ?>
      </center>
   </body>
</html>