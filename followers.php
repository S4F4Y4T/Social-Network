<?php
 include_once"inc/header.php";
 include_once"profile-header.php";

 $followers = userprofile::follower();
 $following = userprofile::following();
?>
        <div class="col-md-12">
            <!-- NAV TABS -->
          <ul class="nav nav-tabs nav-tabs-custom-colored tabs-iconized">
            <li class="active"><a href="#follower" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Followers<?= '('.COUNT($followers).')'; ?></a></li>
            <li class=""><a href="#following" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> Following<?= '('.COUNT($following).')'; ?></a></li>
          </ul>
          <!-- END NAV TABS -->
          <div class="tab-content profile-page">
            <!-- PROFILE TAB CONTENT -->

            <div class="tab-pane profile active" id="follower">
              <?php
                foreach($followers as $result){
              ?>
              <div class="col-md-3">
                <div class="contact-box center-version">
                  <a href='profile.php?username=<?php echo $result['username']; ?>'>
                    <img alt="image" class="img-circle" src="images/profile/<?php echo $result['image']; ?>">
                    <h3 class="m-b-xs"><strong><?php echo $result['name']; ?></strong></h3>

                    <div class="font-bold">Graphics designer</div>

                  <?php if($result['id'] != Session::isloggedin()){ ?>
                    <div class="contact-box-footer">
                      <div class="m-t-xs btn-group">
                        <a href="messages.php?receiver=<?php echo $result['id']; ?>#scroll" class="btn btn-xs btn-white"><i class="fa fa-envelope"></i>Send Messages</a>
                      </div>
                    </div>
                 <?php } ?>
                </a>
              </div>
            </div>
            <?php } ?>
            </div>
            <!-- END PROFILE TAB CONTENT -->

            <!-- SETTINGS TAB CONTENT -->
            <div class="tab-pane settings" id="following">
              <?php
                foreach($following as $result){
              ?>
              <div class="col-md-3">
                <div class="contact-box center-version">
                  <a href='profile.php?username=<?php echo $result['username']; ?>'>
                    <img alt="image" class="img-circle" src="images/profile/<?php echo $result['image']; ?>">
                    <h3 class="m-b-xs"><strong><?php echo $result['name']; ?></strong></h3>

                    <div class="font-bold">Graphics designer</div>

                  <?php if($result['id'] != Session::isloggedin()){ ?>
                    <div class="contact-box-footer">
                      <div class="m-t-xs btn-group">
                        <a href="messages.php?receiver=<?php echo $result['id']; ?>#scroll" class="btn btn-xs btn-white"><i class="fa fa-envelope"></i>Send Messages</a>
                      </div>
                    </div>
                 <?php } ?>
                </a>
              </div>
            </div>
            <?php } ?>
          </div>
          <!-- END SETTINGS TAB CONTENT -->
        </div>
       </div>
    </div>
  </div>
</div>



  <?php include_once"inc/footer.php"; ?>
