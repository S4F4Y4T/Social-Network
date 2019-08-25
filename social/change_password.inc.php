<?php

  include_once'inc/header.inc.php';

  $change_pass = user::verfication($_POST);

  if( $change_pass ){

    if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['change'])){

        $changepass = user::forgottenpass($_POST); // sending request to server

    }

?>
<div class="container page-content edit-profile">
<div class="row">
    <div class="col-md-10 col-md-offset-1">

<form action='<?=  $_GET["token"] ? '?token='.$_GET["token"] : ''; ?>' class="form-horizontal" role="form" method='POST'>
  <fieldset>
    <h3><i class="fa fa-square"></i> Change Password</h3>
    <hr>

    <?php
      if($changepass ){
        echo $changepass;
      }
    ?>

    <div class="form-group">
      <label for="password" class="col-sm-3 control-label">New Password</label>
      <div class="col-sm-4">
        <input type="password" id="password" name="Password" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label for="password2" class="col-sm-3 control-label">Repeat Password</label>
      <div class="col-sm-4">
        <input type="password" id="password2" name="Re-password" class="form-control">
      </div>
    </div>
  </fieldset>

  <?php
    if($_POST['ver_code']){
      echo "<input type='hidden' name='ver_code' value='".$_POST['ver_code']."'>";
    }
  ?>

  <input type='hidden' name='user_id' value='<?= $change_pass; ?>'>


  <p class="text-center"><button name='change' class="btn btn-custom-primary"><i class="fa fa-floppy-o"></i> Save </button></p>
</form>
<!--End of password changing form -->

</div>
</div>
</div>

<?php
  include_once"inc/footer.php";
  }
?>
