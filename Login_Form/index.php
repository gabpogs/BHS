<?php 
  session_start();

  if(isset($_SESSION['log-email'])){
    header("Location: ../Main/home.php");
    exit();
  }

  $status = [
    'login' => $_SESSION['status-login'] ?? '',
    'register' => $_SESSION['status-register'] ?? ''
  ];

  $activeForm = $_SESSION['activeform'] ?? 'login';
  
  function isActiveForm($formname, $activeForm){
    return $formname === $activeForm ? '' : 'd-none';
  }

  function showStatus($status){
    if (!empty($status)){
      if($status == "Success!" or $status == "Cookie!"){
        return "<p class='success-box mb-3'>$status</p>";
      }else{
        echo '<script>console.log("'.$status.'")</script>';
        return "<p class='error-box mb-3'>$status</p>";
      }
    }

    return '';
  }
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="../ImageSource/bhs_icon.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="./index.css" rel="stylesheet"/>
    </head>
    <body class="bg-dark">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        
        <div class="bhs_background"></div>
        <form class="form-signin bg-light p-4 rounded-3 shadow-box <?= isActiveForm('login', $activeForm) ?>" id="login_form" action="../include/login_register.php" method="post">
            <div class="text-center mb-4">
              <img class="mb-4 rounded-2" style="background-color: rgb(245, 245, 245);" src="../ImageSource/bhs_icon.png" alt="" width="72" height="72">
              <h1 class="h3 mb-3 font-weight-normal">Bulacan Hydroponics Supply</h1>
              <!--<p>Build form controls with floating labels via the <code>:placeholder-shown</code> pseudo-element. <a href="https://caniuse.com/#feat=css-placeholder-shown">Works in latest Chrome, Safari, and Firefox.</a></p>-->
            </div>
      
            <?= showStatus($status['login']); ?>

            <div class="form-label-group">
              <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo isset($_SESSION['semail']) ? htmlspecialchars($_SESSION['semail']) : ''; ?>" />
              <label for="inputEmail">Email address</label>
            </div>
            <div class="form-label-group mb-0">
              <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required value="<?php echo isset($_SESSION['spassword']) ? htmlspecialchars($_SESSION['spassword']) : ''; ?>" />
              <label for="inputPassword">Password</label>
            </div>
      
            <small class="" >Don't have an account? <a class="nav-link" href="#" onClick="showform('register_form')">Register</a></small>
      
            <div class="checkbox mb-3 mt-3">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block w-100" name="login" type="submit">Sign in</button>
            <p class="mt-5 text-center text-body-secondary">&copy; 2025</p>
          </form>

          <form class="form-signin bg-light p-4 rounded-3 shadow-box <?= isActiveForm('register', $activeForm) ?>" id="register_form" action="../include/login_register.php" method="post">
            <div class="text-center mb-4">
              <img class="mb-4 rounded-2" style="background-color: rgb(245, 245, 245);" src="../ImageSource/bhs_icon.png" alt="" width="72" height="72">
              <h1 class="h3 mb-3 font-weight-normal">Bulacan Hydroponics Supply</h1>
              <!--<p>Build form controls with floating labels via the <code>:placeholder-shown</code> pseudo-element. <a href="https://caniuse.com/#feat=css-placeholder-shown">Works in latest Chrome, Safari, and Firefox.</a></p>-->
            </div>
            
            <?= showStatus($status['register']); ?>

            <div class="form-label-group">
              <input type="email" id="inputEmailR" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" />
              <label for="inputEmailR">Email address</label>
            </div>

            <div class="form-label-group">
              <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" />
              <label for="inputUsername">Username</label>
            </div>

            <div class="form-label-group">
              <input type="password" id="inputPasswordR" name="password" class="form-control" placeholder="Password" required value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>" />
              <label for="inputPasswordR">Password</label>
            </div>

            <div class="form-label-group">
              <input type="password" id="inputCPassword" name="cpassword" class="form-control" placeholder="Confirm Password" required value="<?php echo isset($_SESSION['cpassword']) ? htmlspecialchars($_SESSION['cpassword']) : ''; ?>" />
              <label for="inputCPassword">Confirm Password</label>
            </div>

            <div class="form-label-group mb-0">
              <input type="text" id="inputCookie" name="cookie" class="form-control" placeholder="Cookie" required value="<?php echo isset($_SESSION['cookie']) ? htmlspecialchars($_SESSION['cookie']) : ''; ?>" />
              <label for="inputCookie">Cookie</label>
            </div>
      
            <small class="" >Already have an account? <a class="nav-link" href="#" onClick="showform('login_form')">Log-in</a></small>
      
            <button class="btn mt-3 btn-lg btn-primary btn-block w-100" name="register" type="submit">REGISTER</button>
            <p class="mt-5 text-center text-body-secondary">&copy; 2025</p>
          </form>
            
          <script src="index.js"></script>

          <?php 
            session_unset();
          ?>
    </body>
</html>