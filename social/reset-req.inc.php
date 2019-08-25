<?php

  include_once'inc/header.inc.php';

    $reset_req = user::resetreq($_POST);
    if($reset_req){

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

              <form action='change_password.inc.php' class="form-horizontal" role="form" method='POST'>
                <h5><b>Mail sent to:</b> <?= $_POST['email']; ?></h5>
                <div class="form-group">
                  <div class="col-md-12">
                    <input type="name" name='ver_code' class="form-control" placeholder="verification code">
                  </div>
                </div>
                <input type='hidden' name='email' value='<?= $_POST['email']; ?>'>
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
?>
