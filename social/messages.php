<?php
  include_once"inc/header.php";

  $user = massenger::list();

  $read     = massenger::read();

  if($_SERVER['REQUEST_METHOD'] == 'POST' && ISSET($_POST['send'])){
      $post = massenger::send($_POST);
  }

?>

<!-- Begin page content -->
<div class="container page-content">
  <div class="row">
    <div class="col-md-4 bg-white">
      <div class=" row border-bottom padding-sm" style="height: 40px;">
      Member
      </div>
      <!-- member list -->
      <ul class="friend-list">
        <?php

          if($user){
          foreach($user as $result){

        ?>
      <li>
        <a href="?receiver=<?= $result['id']; ?>#scroll" class="clearfix">
          <img src="images/profile/<?= $result['image']; ?>" alt="" class="img-circle">
          <div class="friend-name">
            <strong><?= $result['name']; ?></strong>
          </div>
          <?php
          $messages = massenger::message($result['id']);
          foreach($messages as $value){ ?>
              <?php if($value['seen'] == 0 AND $value['receiver'] == Session::isloggedin()){ ?>
                  <div class="last-message text-muted"><strong><?= $value['message']; ?></strong></div>
              <?php }else{ ?>
                  <div class="last-message text-muted"><?= substr($value['message'],0,20); ?></div>

              <small class="time text-muted"><?= $value['date']; ?></small>
              <?php } ?>
        <?php } ?>
        </a>
      </li>

    <?php }} ?>

      </ul>
    </div>

    <!--=========================================================-->
    <!-- selected chat -->
    <div class="col-md-8 bg-white ">
      <div class="chat-message" style="max-height: 600px;overflow-y:auto ">
        <ul class="chat">
          <?php
            foreach($read as $result){
              if(userprofile::username()[0]['username'] == $result['Receiver']){
          ?>


            <li class="left clearfix">
              <a href='profile.php?username=<?= $result['Sender']; ?>'>
                <span class="chat-img pull-left">
                  <img src="images/profile/<?= $result['image']; ?>" alt="User Avatar">
                </span>
              </a>
              <div class="chat-body clearfix">
                <div class="header">
                  <strong class="primary-font"><?= $result['Sender']; ?></strong>
                  <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?= $result['date']; ?></small>
                </div>
                <p>
                  <?= $result['message']; ?>
                </p>
              </div>
            </li>
          <?php }else{ ?>

            <li class="right clearfix">
              <a href='profile.php?username=<?= $result['Sender']; ?>'>
                <span class="chat-img pull-right">
                  <img src="images/profile/<?= $result['image']; ?>" alt="User Avatar">
                </span>
              </a>
              <div class="chat-body clearfix">
                <div class="header">
                  <strong class="primary-font"><?= $result['Sender']; ?></strong>
                  <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?= $result['date']; ?></small>
                </div>
                <p>
                <?= $result['message']; ?>
                </p>
              </div>
            </li>

          <?php }} ?>
          <a name='scroll'></a>
        </ul>
      </div>

      <div class="chat-box_ bg-white">
        <form action='' method='post'>
          <div class="input-group">
            <input name='body' class="form-control border no-shadow no-rounded" placeholder="Type your message here">
            <span class="input-group-btn">
              <button class="btn btn-success no-rounded" type="submit" name='send'>Send</button>
            </span>
            <input type='hidden' name='receiver' value='<?= $_GET['receiver'] ? $_GET['receiver'] : '' ?> '>
          </div><!-- /input-group -->
        </form>
      </div>

    </div>
  </div>
</div>

    <?php include_once"inc/footer.php"; ?>
