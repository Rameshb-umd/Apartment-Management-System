<?php
   ob_start();
   session_start();
   $page_title = 'Login Page';
   include ('connect_to_sql.php');
?>
<html lang="en">
<link rel="stylesheet" href="styles.css" type="text/css">
<body>
      
            <?php
            $msg = '';
          
           //logic to check if correct user id and password entered - Start()
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
				
                $username=$_POST['username'];
                $password=$_POST['password'];
                $result = @mysqli_query($dbc, "select count(1) from members where username='$username' and password='$password'");
                $row = mysqli_fetch_array($result, MYSQL_NUM);
                $noOfrecords=$row[0];
                
               if ($noOfrecords>0) {
                  $_SESSION['username'] = $username;
                  header('Location: home.php');  
               }else {
                  $msg = 'Wrong username or password';
               }
            }
          //logic to check if correct user id and password entered - End()
         ?>
        
        <!-- /container -->

        <!-- /Login Form -->
        <div class="container">
            <h2>Enter Username and Password</h2>
            <form class="form-signin" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <h4 class="form-signin-heading"><?php echo $msg; ?></h4> User Name&nbsp;:
                <input type="text" class="form-control" name="username" placeholder="admin" required autofocus style="width:70%;height:40px;">
                </br>
                </br>
                Password &nbsp;&nbsp;&nbsp;:
                <input type="password" class="form-control" name="password" placeholder="admin" required style="width:70%;height:40px;">
                </br>
                </br>
                <button style="width:100%;height:50px;" type="submit" name="login">Login</button>
            </form>
        </div>
    </body>

    </html>