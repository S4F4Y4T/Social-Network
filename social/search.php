<?php include_once"inc/header.php";

  $search = userprofile::search();

?>
<!-- Begin page content -->
    <div class="container page-content ">

      <div class="directory-info-row">
          <div class="row">
            <?php
              foreach($search as $result){
            ?>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="panel">
                  <div class="panel-body">
                      <div class="media">
                          <a class="pull-left" href="?profile.php?username=<?php echo $result['username']; ?>">
                              <img class="thumb media-object" src="images/profile/<?php echo $result['image']; ?>" alt="">
                          </a>
                          <div class="media-body">
                              <h4><a href="profile.php?username=<?php echo $result['username']; ?>"><?php echo $result['name']; ?></a> <span class="text-muted small"> - UI Engineer</span></h4>
                              <address>
                                  <strong><?php echo $result['job']; ?>.</strong><br>
                                  <?php echo $result['address']; ?><br>
                                  <abbr title="Phone">P:</abbr> <?php echo $result['email']; ?><br>
                                  <br>
                              </address>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>

        </div>
      </div>
    </div>

<?php include_once"inc/footer.php"; ?>
