<?php include_once'inc/header.inc.php'; ?>

    <!-- Begin page content -->
    <div class="container page-content ">
      <div class="row">
        <div class="col-md-6  col-sm-8 col-xs-12 col-md-offset-3">
          <div class="panel panel-primary" id="locked-screen">
            <div class="panel-heading">
                <h3 class="panel-title">
                Please enter your email address
            </h3>
            </div>
            <div class="panel-body">
              <form action='reset-req.inc.php' class="form-horizontal" role="form" method='post'>

                <?php
        					if(!empty($_GET['msg'])){
        						$msg = $_GET['msg'];
        						$msg = unserialize(urldecode($msg));
                    echo $msg;
        					}
        				?>

                <div class="form-group">
                  <div class="col-md-12">
                    <input type="email" name='email' class="form-control" id="email" placeholder="Email">
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

<?php include_once"inc/footer.php"; ?>
