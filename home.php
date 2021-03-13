<?php

  include_once"inc/header.php";

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['like'])){
      $post = timeline::like($_POST);
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['post'])){
      $post = timeline::post($_POST);
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['comment'])){
      $post = timeline::comment($_POST);
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['follow'])){
      userprofile::follow();
  }

?>
  <!-- Begin page content -->
    <div class="container page-content ">
      <div class="row">
        <!-- left links -->
        <div class="col-md-3">
          <div class="profile-nav">
            <div class="widget">
              <div class="widget-body">

                <ul class="nav nav-pills nav-stacked">
                  <li class="active"><a href=""> <i class="fa fa-user"></i> News feed</a></li>
                  <li>
                    <a href="messages.php">
                      <i class="fa fa-envelope"></i> Messages
                      <span class="label label-info pull-right r-activity"><?php $message = massenger::unseen(); if($message){ echo COUNT($message); } ?></span>
                    </a>
                  </li>
                  <li><a href="profile.php"> <i class="fa fa-user"></i> Profile</a></li>
                  <li><a href="photos.php"> <i class="fa fa-image"></i> Photos</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div><!-- end left links -->


        <!-- center posts -->
        <div class="col-md-6">
          <div class="row">
            <!-- left posts-->
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12">
                  <?php
                    $post =  timeline::isUser();
                    if( $post ){
                  ?>
                  <!-- post state form -->
                    <div class="box profile-info n-border-top">
                      <form action='' method='POST' enctype="multipart/form-data">
                          <input type='hidden' name='token' value='<?= Session::get('token'); ?>'>
                          <textarea onclick="this.value=''" name='body' class="form-control input-lg p-text-area" rows="2" placeholder="Whats in your mind today?"></textarea>
                          <div class="box-footer box-form">
                              <button type="submit" name='post' class="btn btn-azure pull-right">Post</button>
                              <ul class="nav nav-pills">
                                <li>
                                  <span class="file-input btn btn-azure btn-file">
                                    <i class="fa fa-camera"></i> <input name='image' type="file">
                                  </span>
                              </li>
                              </ul>
                          </div>
                      </form>
                    </div><!-- end post state form -->

                    <?php
                  }
                      $post = timeline::timelinepost();
                      if($post){
                      foreach($post as $value){
                    ?>

                    <!--   posts -->
                    <div class="box box-widget" id='<?php echo $value['post_id']?>'>
                      <div class="box-header with-border">
                        <div class="user-block">
                          <img class="img-circle" src="images/profile/<?php echo $value['image']?>" alt="User Image">
                          <span class="username">
                            <a href="profile.php?username=<?= $value['username']?>">
                              <?php echo $value['name']?>
                            </a>
                         </span>
                          <span class="description"><?php echo $value['posted_at']?></span>
                        </div>
                      </div>

                      <div class="box-body" style="display: block;">

                          <?php echo $value['post_image'] ? '<img class="img-responsive show-in-modal" src="images/others/'.$value['post_image'].'" alt="Photo">' : ''; ?>

                        <p><?php echo $value['body']?></p>

                        <form action='' method='POST'>
                          <?php
                            echo timeline::isliked($value['post_id']);
                          ?>
                          <input type='hidden' name='post_id' value='<?php echo $value['post_id']; ?>'>
                          <span class="pull-right text-muted">
                            <?php
                             if($value['likes'] != 0){ echo $value['likes'].' likes'; }
                             if($value['likes'] != 0 AND $value['comments'] != 0){ echo ' - '; }
                             if($value['comments'] != 0){ echo $value['comments'].' comments'; }
                           ?>
                         </span>
                        </form>

                      </div>
                      <div class="box-footer box-comments" style="display: block;">

                      <?php
                        $comment = timeline::fetchcomment($value['post_id']);
                        foreach($comment as $val){
                      ?>

                        <div class="box-comment">
                          <img class="img-circle img-sm" src="images/profile/<?php echo $val['image']?>" alt="User Image">
                          <div class="comment-text">
                            <span class="username">
                              <a href="profile.php?username=<?= $val['username']?>">
                                  <?php echo $val['name']?>
                              </a>
                              <span class="text-muted pull-right">
                                <?php echo $val['posted_at_com']?>
                              </span>

                            </span>
                            <?php echo $val['comment']?>
                          </div>
                        </div>
                  <?php
                    }
                  ?>

                      </div>
                      <div class="box-footer" style="display: block;">
                        <form action="" method="post">
                          <img class="img-responsive img-circle img-sm" src="images/profile/<?= userprofile::profile()[0]['image']; ?>" alt="Alt Text">
                          <div class="img-push">
                            <input type="text" name="comment" class="form-control input-sm" placeholder="Press enter to post comment">
                            <input type="hidden" name="post_id" value="<?= $value['post_id'] ?>">
                          </div>
                        </form>
                      </div>
                    </div><!--  end posts-->
                    <?php
                      }}
                    ?>
                </div>
              </div>
            </div><!-- end left posts-->
          </div>
        </div><!-- end  center posts -->




        <!-- right posts -->
        <div class="col-md-3">

          <!-- People You May Know -->
          <div class="widget affix">
            <div class="widget-header">
              <h3 class="widget-caption">People You May Know</h3>
            </div>
            <div class="widget-body bordered-top bordered-sky">
              <div class="card">
                  <div class="content">
                      <ul class="list-unstyled team-members">
                        <?php
                         $user = userprofile::suggestpeople();
                         if($user){
                         foreach($user as $result){
                           if($result['id'] != Session::isloggedin()){

                             //if($result['id'] != userprofile::following()[0]['id']){
                        ?>
                          <li>
                              <div class="row">
                                  <div class="col-xs-3">
                                      <div class="avatar">
                                          <img src="images/profile/<?= $result['image']; ?>" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                      </div>
                                  </div>
                                  <div class="col-xs-6">
                                     <a href="profile.php?username=<?= $result['username']; ?>"><?= $result['name']; ?></a>
                                  </div>

                                  <div class="col-xs-3 text-right">
                                      <form action='' method='POST'>
                                        <button type='submit' name='follow' class="btn btn-sm btn-azure btn-icon"><i class="fa fa-user-plus"></i></button>
                                        <input type='hidden' name='receiver' value='<?= $result['id']; ?>'>
                                      </form>
                                  </div>
                              </div>
                          </li>
                          <?php
                        }}}
                        $limit = userprofile::suggestlimit($user);
                        if($limit){
                          foreach($limit as $result){
                            if($result['id'] != Session::isloggedin()){

                              //if($result['id'] != userprofile::following()[0]['id']){
                         ?>
                           <li>
                               <div class="row">
                                   <div class="col-xs-3">
                                       <div class="avatar">
                                           <img src="images/profile/<?= $result['image']; ?>" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                       </div>
                                   </div>
                                   <div class="col-xs-6">
                                      <a href="profile.php?username=<?= $result['username']; ?>"><?= $result['name']; ?></a>
                                   </div>

                                   <div class="col-xs-3 text-right">
                                       <form action='' method='POST'>
                                         <button type='submit' name='follow' class="btn btn-sm btn-azure btn-icon"><i class="fa fa-user-plus"></i></button>
                                         <input type='hidden' name='receiver' value='<?= $result['id']; ?>'>
                                       </form>
                                   </div>
                               </div>
                           </li>
                           <?php
                         }}}
                           ?>


                      </ul>
                  </div>
              </div>
            </div>
          </div><!-- End people yout may know -->
        </div><!-- end right posts -->
      </div>
    </div>

  <?php include_once"inc/footer.php"; ?>
