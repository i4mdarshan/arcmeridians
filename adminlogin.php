 <?php


require'include/common/config.php';
 

$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
            $username = trim($_POST["username"]);
    }
    
    
    if(empty($_POST["password"])){
        $password_err = "Please enter your password.";
    } else{
        $password = $_POST["password"];
    }
    
    if(empty($username_err) && empty($password_err)){
        
        $sql = "SELECT admin_id, username, pass FROM login WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            $param_username = $username;
           
            
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){
                        if($password==$hashed_password){
                            
                            session_start();
                            
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["admin_id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            
                            header("location:welcome.php");

                        } else{
                            
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Theme style -->
  <link rel="stylesheet" href="include/css/adminlte.min.css">
  <!-- Custom sheet -->
  <link rel="stylesheet" href="include/css/custom.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
 </head>
<style type="text/css">
  :root {
  --input-padding-x: 1.5rem;
  --input-padding-y: 0.75rem;
}

.login,
.image {
  min-height: 100vh;
}

.bg-image {
  background-image: url('include/img/wall_background.png');
  background-size: cover;
  background-position: center;
}

.login-heading {
  color: white;
  font-weight: 300;
}

.bg-color{
  background-color: #282828;
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
  border-radius: 2rem;
}

.form-label-group {
  position: relative;
  margin-bottom: 1rem;
}

.form-label-group>input,
.form-label-group>label {
  padding: var(--input-padding-y) var(--input-padding-x);
  height: auto;
  border-radius: 2rem;
}

.form-label-group>label {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0;
  /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  cursor: text;
  /* Match the input under the label */
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
  padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group input:not(:placeholder-shown)~label {
  padding-top: calc(var(--input-padding-y) / 3);
  padding-bottom: calc(var(--input-padding-y) / 3);
  font-size: 12px;
  color: #777;
}

 a.cactive{
   color: #f0575a ;
 }

 a:hover{
  color: #f0575a ;
 }
 .custom-footer{
      color: #869099;
      position:auto;
      bottom: 0;
      padding: 10px 10px 0px 10px;
      width: 100%;
      height: 40px;
      text-align: center;
  }
/* Fallback for Edge
-------------------------------------------------- */

@supports (-ms-ime-align: auto) {
  .form-label-group>label {
    display: none;
  }
  .form-label-group input::-ms-input-placeholder {
    color: #777;
  }
}

/* Fallback for IE
-------------------------------------------------- */

@media all and (-ms-high-contrast: none),
(-ms-high-contrast: active) {
  .form-label-group>label {
    display: none;
  }
  .form-label-group input:-ms-input-placeholder {
    color: #777;
  }
}

</style>
<body class="body-bg">
<div class="wrapper">

<div class="container-fluid bg-color">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-5 col-lg-7 bg-image"></div>
    <div class="col-md-7 col-lg-5">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <div class="d-block d-sm-none mb-5 container"><img src="include/img/arc_meridians_brandname@4x.png" style="height: 60px;"></div>
              <h3 class="login-heading mb-4 text-center">Welcome!</h3>
              <h5 class="login-heading mb-4 text-center">
                        <a href="userlogin.php" id="acustom" style="text-decoration: none; ">User</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a href="adminlogin.php" id="acustom" style="text-decoration: none; " class="cactive">Admin</a>
              </h5>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-label-group">
                  <input type="text" name="username" value="<?php echo $username; ?>" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                  <label for="inputEmail">Username</label>
                  <div class="alert-danger mt-3"><?php echo $username_err; ?></div>
                </div>

                <div class="form-label-group">
                  <input type="password" name="password" value="<?php echo $password; ?>" id="inputPassword" class="form-control" placeholder="Password" required>
                  <label for="inputPassword">Password</label>
                  <div class="alert-danger mt-3"><?php echo $password_err; ?></div>
                </div>

                <div class="custom-control custom-checkbox mb-3">
                  
                </div>
                <button class="btn btn-lg btn-danger btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Login</button>
                <div class="text-center">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
  <div class="custom-footer">
    <strong><span style="color: #f0575a;">A</span>rc <span style="color: #f0575a;">M</span>eridians &copy; 2020.</strong> All rights reserved.
  </div>
<!-- Jquery -->
<script src="include/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="include/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="include/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="include/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="include/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="include/js/demo.js"></script>

</body>
</html>