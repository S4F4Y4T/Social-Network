<?php
 include_once"inc/header.php";
 $notification = timeline::notification();

?>

<!-- Begin page content -->
    <div class="container page-content ">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-inside-lg decor-default activities animated fadeInUp" id="activities">
                <h6>Notification</h6>

                <?php
                  foreach($notification as $result){
                ?>

                <div class="unit">
                    <a class="avatar" href="#"><img src="images/profile/<?= $result['image']; ?>" class="img-responsive" alt="profile"></a>
                    <div class="field title">
                      <?php if($result['type'] == 1){
                        echo "<a href='profile.php?username=".$result['username']."'>".$result['name']."</a> started following you";
                      }else if($result['type'] == 2){
                        echo "<a href='profile.php?username=".$result['username']."'>".$result['name']."</a><a style='font-weight:normal' href='profile.php?username=".$result['username']."'> mention you in a post</a>";
                      }else if($result['type'] == 3){
                        echo "<a href='profile.php?username=".$result['username']."'>".$result['name']."</a><a style='font-weight:normal' href='profile.php#".$result['post']."'>  mention you in a comment</a>";
                      }else if($result['type'] == 4){
                        echo "<a href='profile.php?username=".$result['username']."'>".$result['name']."</a><a style='font-weight:normal' href='profile.php#".$result['post']."'> liked your post</a>";
                      }else if($result['type'] == 5){
                        echo "<a href='profile.php?username=".$result['username']."'>".$result['name']."</a><a style='font-weight:normal' href='profile.php#".$result['post']."'> commnet on your post</a>";
                      }
                       ?>
                    </div>
                    <div class="field date">
                        <span class="f-l"><?= $result['date']; ?></span>
                    </div>
                </div>
                <?php
                  }
                ?>
            </div>
        </div>
      </div>
    </div>

<?php include_once"inc/footer.php"; ?>
