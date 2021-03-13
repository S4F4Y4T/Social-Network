

<?php
    include_once'classes/user.php';

    spl_autoload_register(function($class){
      include'lib/'.$class.'.php';
    });
    Session::chklogin();

    if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['login'])){
        $login = user::login($_POST); // sending request to server
    }

    include_once'inc/header.inc.php';

?>

    <div class="wrapper">

      <div class="parallax filter-black">
          <div class="parallax-image"></div>
          <div class="small-info">

            <div class="col-sm-10 col-sm-push-1 col-md-6 col-md-push-3 col-lg-6 col-lg-push-3">
              <div class="card-group animated flipInX">
                <div class="card">
                  <div class="card-block center">
                      <h4 class="m-b-0"><span class="icon-text">Login</span></h4>
                      <p class="text-muted">Access your account</p>

                    <!-- LOGIN FORM -->

                    <?php
                      if(isset($login)){
                        echo $login; //response info
                      }
                    ?>

                    <form action="" method="POST">
                      <div class="form-group">
                        <input name='user' type="text" class="form-control" placeholder="Email Address Or Username">
                      </div>
                      <div class="form-group">
                        <input name='Password' type="Password" class="form-control" placeholder="Password">
                        <a href="recover_password.php" class="pull-xs-right">
                          <small>Forgot?</small>
                        </a>
                        <div class="clearfix"></div>
                      </div>
                      <div class="center">
                        <button name='login' type="login" class="btn btn-azure">Login</button>
                      </div>
                    </form>

                    <!-- LOGIN FORM END HERE-->

                  </div>
                </div>

                <div class="card">

                  <div class="card-block center">
                    <h4 class="m-b-0">
                      <span class="icon-text">Sign Up</span>
                    </h4>
                    <p class="text-muted">Create a new account</p>

                    <!-- REGISTATION FORM -->
                    <?php
            					if(!empty($_GET['msg'])){
            						$msg = $_GET['msg'];
            						$msg = unserialize(urldecode($msg));
                        echo $msg;
            					}
            				?>

                    <form action="mailver.inc.php" method="post">
                      <div class="form-group">
                        <input name='Name' type="text" class="form-control" placeholder="Full Name">
                      </div>
                      <div class="form-group">
                        <input name='Username' type="text" class="form-control" placeholder="username">
                      </div>
                      <div class="form-group">
                        <input name='Email' type="email" class="form-control" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <input name='Password' type="password" class="form-control" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <input name='Re-password' type="password" class="form-control" placeholder="Retype Password">
                      </div>
                      <button name='register' type="submit" class="btn btn-azure">Register</button>
                    </form>

                    <!-- REGISTATION FORM END HERE-->

                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

<?php include_once'inc/footer.php'; ?>
