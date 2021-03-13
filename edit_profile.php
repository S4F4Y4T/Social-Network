<?php include_once"inc/header.php"; ?>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['change'])){
    $changepass = user::changepassword($_POST); // sending request to server
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['avatar'])){
    $changeimage = userprofile::profileimage($_POST); // sending request to server
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['about'])){
    $profile = userprofile::about($_POST); // sending request to server
}

?>


  <!-- Begin page content -->
    <div class="container page-content edit-profile">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <!-- NAV TABS -->
          <ul class="nav nav-tabs nav-tabs-custom-colored tabs-iconized">
            <li class="active"><a href="#profile-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Profile</a></li>
            <li class=""><a href="#settings-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> Settings</a></li>
          </ul>
          <!-- END NAV TABS -->
          <div class="tab-content profile-page">
            <?php
            if(isset($changeimage)){
              echo $changeimage;
            }
            ?>
            <!-- PROFILE TAB CONTENT -->
            <div class="tab-pane profile active" id="profile-tab">
              <div class="row">
                <div class="col-md-3">
                  <div class="user-info-left">
                    <img src="images/profile/<?= userprofile::profile()[0]['image']; ?>" alt="people">
                    <h2><?= userprofile::profile()[0]['name']; ?></h2>

                    <div class="contact">


                      <form action='' method='POST' enctype="multipart/form-data">
                          <p>
                            <span class="file-input btn btn-azure btn-file">
                              Change Avatar <input name='avatar' type="file">
                            </span>
                          </p>
                          <p>
                            <span class="file-input btn btn-azure btn-file">
                              Change Cover <input name='cover' type="file">
                            </span>
                          </p>
                          <button name='avatar' class="file-input btn btn-azure btn-file">change</button>
                        </form>

                    </div>

                  </div>
                </div>
                <div class="col-md-9">
                  <div class="user-info-right">
                    <?php
                    if(isset($profile)){
                      echo $profile;
                    }
                    ?>
                    <form action='' method='POST'>
                      <div class="basic-info">
                        <h3><i class="fa fa-square"></i> Basic Information</h3>
                        <p class="data-row">
                          <span class="data-name">Name</span>
                          <span class="data-value"><input type='text' name='Name' value='<?= userprofile::profile()[0]['name']; ?>'></span>
                        </p>
                        <p class="data-row">
                          <span class="data-name">Birth Date</span>
                          <span class="data-value"><input type="date" min='1970-01-01' max= '<?= '20'.date('y-m-d'); ?>'  name="Birthdate" value="<?= userprofile::profile()[0]['birthdate']; ?>"></span>
                        </p>
                        <p class="data-row">
                          <span class="data-name">Gender</span>
                          <span class="data-value">
                               <label><input type="radio"  name="Gender" value='Male' checked>Male</label>

                               <label><input type="radio" name="Gender" value='Female'>/ Female</label>
                          </span>
                        </p>
                        <p class="data-row">
                          <span class="data-name">Job</span>
                          <span class="data-value"><input type='text' name='Job' value='<?= userprofile::profile()[0]['job']; ?>'></span>
                        </p>
                        <p class="data-row">
                          <span class="data-name">Address</span>
                          <span class="data-value"><input type='text' name='Address' value='<?= userprofile::profile()[0]['address']; ?>'></span>
                        </p>
                      </div>
                      <div class="about">
                        <h3><i class="fa fa-square"></i> Bio</h3>
                        <textarea name='Bio' rows="8" cols="80"><?= userprofile::profile()[0]['about']; ?></textarea>
                      </div>
                    </div>
                    <br>
                    <p class="text-center"><button name='about' class="btn btn-custom-primary"><i class="fa fa-floppy-o"></i> Save Changes </button></p>
                </form>
                </div>
              </div>
            </div>
            <!-- END PROFILE TAB CONTENT -->


            <!-- SETTINGS TAB CONTENT -->
            <div class="tab-pane settings" id="settings-tab">

              <!--End of password changing form -->
              <?php
                if(isset($changepass)){
                  echo $changepass; //response info
                }
              ?>

              <form action='' class="form-horizontal" role="form" method='POST'>
                <fieldset>
                  <h3><i class="fa fa-square"></i> Change Password</h3>
                  <div class="form-group">
                    <label for="old-password" class="col-sm-3 control-label">Old Password</label>
                    <div class="col-sm-4">
                      <input type="password" id="old-password" name="old-password" class="form-control">
                    </div>
                  </div>
                  <hr>
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
                <fieldset>
                  <div class="checkbox">
                    <label>
                        <input type="checkbox" class="colored-blue" name='alldevice'>
                        <span class="text">Logout From Other Device</span>
                    </label>
                  </div>

                </fieldset>

                <p class="text-center"><button name='change' class="btn btn-custom-primary"><i class="fa fa-floppy-o"></i> Save Changes </button></p>
              </form>
              <!--End of password changing form -->

            </div>
            <!-- END SETTINGS TAB CONTENT -->
          </div>
        </div>
      </div>
    </div>

    <?php include_once"inc/footer.php"; ?>
