<?php

  include_once'inc/header.inc.php';

  if( ($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['submit'])) || $_GET['token'] ){

      $ver = user::mailverification($_POST); // sending request to server

  } else {

    $registration = user::registration($_POST); // sending request to server

    if($registration['status']){

?>

    <!-- Begin page content -->
    <div class="container page-content ">
      <div class="row">
        <div class="col-md-6  col-sm-8 col-xs-12 col-md-offset-3">
          <div class="panel panel-primary" id="locked-screen">
            <div class="panel-heading">
                <h3 class="panel-title">
                verification code
            </h3>
            </div>
            <div class="panel-body">

              <form action='' class="form-horizontal" role="form" method='post'>
                <h5><b>Mail sent to: </b> <?= $_POST['Email']; ?></h5>
                <h3>If your server is not live then mail should not be sent so here is your Mail: </h3>
                <p>
                    <?php
                        print_r($registration['message']);
                    ?>
                </p>
                <div class="form-group">
                  <div class="col-md-12">
                    <input type="name" name='ver_code' class="form-control" placeholder="verification code">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12">
                    <button type='submit' name='submit' class="btn btn-info btn-block">
                      <i class="fa fa-share"></i>
                      Continue
                    </button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

<?php
  include_once"inc/footer.php";
}
}
?>
