<?php
 include_once"inc/header.php";

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['follow'])){
      userprofile::follow();
  }else if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['inbox'])){
    header('Location:messages.php?receiver='.$_POST['receiver'].'#scroll');
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['post'])){
      $post = timeline::post($_POST);
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['like'])){
      $post = timeline::like($_POST);
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['comment'])){
      $post = timeline::comment($_POST);
  }

 include_once"profile-header.php";
?>


<div class="row">
<div class="col-md-5">
  <div class="widget">
    <div class="widget-header">
      <h3 class="widget-caption">About</h3>
    </div>
    <div class="widget-body bordered-top bordered-sky">
      <ul class="list-unstyled profile-about margin-none">
        <li class="padding-v-5">
          <div class="row">
            <div class="col-sm-4"><span class="text-muted">Date of Birth</span></div>
            <div class="col-sm-8"><?= userprofile::profile()[0]['birthdate']; ?></div>
          </div>
        </li>
        <li class="padding-v-5">
          <div class="row">
            <div class="col-sm-4"><span class="text-muted">Job</span></div>
            <div class="col-sm-8"><?= userprofile::profile()[0]['job']; ?></div>
          </div>
        </li>
        <li class="padding-v-5">
          <div class="row">
            <div class="col-sm-4"><span class="text-muted">Gender</span></div>
            <div class="col-sm-8"><?= userprofile::profile()[0]['gender']; ?></div>
          </div>
        </li>
        <li class="padding-v-5">
          <div class="row">
            <div class="col-sm-4"><span class="text-muted">Lives in</span></div>
            <div class="col-sm-8"><?= userprofile::profile()[0]['address']; ?></div>
          </div>
        </li>
        <li class="padding-v-5">
          <div class="row">
            <div class="col-sm-4"><span class="text-muted">About</span></div>
            <div class="col-sm-8"><?= userprofile::profile()[0]['about']; ?></div>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <div class="widget">
   <div class="widget-header">
      <h3 class="widget-caption">Photos</h3>
    </div>
    <div class="widget-body bordered-top  bordered-sky">
      <div class="row">
        <div class="col-md-12">
          <ul class="img-grid" style="margin: 0 auto;">
            <?php
              $photos = timeline::timelinephotos();
              if($photos){
              foreach($photos as $result){
            ?>
            <li>
              <a href="photos.php<?php if(isset($_GET['username'])){echo'?username='.$_GET['username']; }?>">
              <img src="images/others/<?= $result['post_image']?>" alt="<?= $result['post_image']?>">
            </a>
            </li>
          <?php }} ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="widget">
   <div class="widget-header">
      <h3 class="widget-caption">Followers</h3>
    </div>
    <div class="widget-body bordered-top  bordered-sky">
      <div class="row">
        <div class="col-md-12">
          <ul class="img-grid" style="margin: 0 auto;">
            <?php
              $follower = userprofile::timelinefollower();
              if($follower){
              foreach($follower as $result){
            ?>
            <li>
              <a href="followers.php<?php if(isset($_GET['username'])){echo'?username='.$_GET['username']; }?>">
                <img src="images/profile/<?= $result['image']?> " alt="image">
              </a>
            </li>
          <?php }} ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!--============= timeline posts-->
<div class="col-md-7">
  <div class="row">
    <!-- left posts-->
    <div class="col-md-12" style='margin-bottom:50px'>
      <div class="row">
        <div class="col-md-12">

        <?php
          if(isset($post)){
            echo $post;
          }
          $post =  timeline::isUser();
          if( $post ){
        ?>
        <!-- post state form -->
          <div class="box profile-info n-border-top">
            <form action='' method='POST' enctype="multipart/form-data">
                <input type='hidden' name='csrf' value='<?= Session::get('csrf'); ?>'>
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
    $post = timeline::fetchpost();
    if($post){
    foreach($post as $value){
  ?>

  <!--   posts -->
  <div class="box box-widget" id='<?php echo $value['post_id']?>'>
    <div class="box-header with-border">
      <div class="user-block">
        <img class="img-circle" src="images/profile/<?php echo $value['image']?>" alt="User Image">
        <span class="username"><?php echo $value['name']?></span>
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
        <input type='hidden' name='csrf' value='<?= Session::get('csrf'); ?>'>
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
          <input type='hidden' name='csrf' value='<?= Session::get('csrf'); ?>'>
        </div>
      </form>
    </div>
  </div><!--  end posts-->
            <?php
              }}else{
                echo '<center style="margin:30px">such a empty</center>';
              }
            ?>
    </div>
  </div>
</div>

  <?php if(userprofile::profile()[0]['id'] == Session::isloggedin()){ ?>
  <!-- Online users sidebar content-->
  <div class="chat-sidebar focus">
    <div class="list-group text-left">
      <p class="text-center visible-xs"><a href="#" class="hide-chat btn btn-success">Hide</a></p>
      <p class="text-center chat-title">Online users</p>
      <?php
        $user = user::onlineusers();
        if($user){
        foreach($user as $result){
      ?>
      <a href="messages.php?receiver=<?= $result['id']; ?>#scroll" class="list-group-item">
        <i class="fa fa-check-circle connected-status"></i>
        <img src="images/profile/<?= $result['image']; ?>" class="img-chat img-thumbnail">
        <span class="chat-user-name"><?= $result['name']; ?></span>
      </a>
      <?php
    }}else{
      echo '<center>such a empty</center>';
    }}
      ?>
    </div>
  </div><!-- Online users sidebar content-->
<!-- Modal -->
<div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Image</h4>
      </div>
      <div class="modal-body text-centers">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include_once"inc/footer.php"; ?>
