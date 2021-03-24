<?php
  ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
  include_once'classes/user.php';
  include_once'classes/userprofile.php';
  include_once'classes/timeline.php';
  include_once'classes/massenger.php';
  include_once'classes/comment.php';
  include_once'classes/fetchposts.php';
  include_once'classes/photo.php';
  include_once'classes/posts.php';

  spl_autoload_register(function($class){
    include'lib/'.$class.'.php';
  });

  Session::chklogout();
  user::active();
  
  Session::init();
  if(!(Session::get('csrf'))){
    $cstrong = true;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    Session::set('csrf',$token);
  }

  if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    Session::logout();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/others/favicon.png">
    <title>S4F4Y4T-SOCAIL</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.3.3.6/css/bootstrap.min.css?v=2.6" rel="stylesheet">
    <link href="assets/font-awesome.4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/timeline.css?v=1.2" rel="stylesheet">
    <link href="assets/css/cover.css?v=1.6" rel="stylesheet">
    <link href="assets/css/forms.css?v=1" rel="stylesheet">
    <link href="assets/css/buttons.css?v=1.3" rel="stylesheet">
    <link href="assets/css/messages1.css" rel="stylesheet">
    <link href="assets/css/friends.css" rel="stylesheet">
    <link href="assets/css/people_directory.css" rel="stylesheet">
    <link href="assets/css/user_detail.css" rel="stylesheet">
    <link href="assets/css/edit_profile.css" rel="stylesheet">
    <link href="assets/css/list_posts.css" rel="stylesheet">
    <link href="assets/css/photos1.css" rel="stylesheet">
    <script src="assets/js/jquery.1.11.1.min.js"></script>
    <script src="assets/bootstrap.3.3.6/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/css/custom.css?v=1"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-white navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <div class='res-nav'>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=""><b>S4F4Y4T-SOCIAL</b></a>
          </div>


        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right res-ul">
            <li class='res-li'>
              <form action='search.php' method='get'>
                <input type="text" name='q' class="form-control" placeholder="Search" id="txtSearch"/>
              </form>
            </li>
            <li><a href="home.php">Home</a></li>
      	    <li class="actives"><a href="profile.php">Profile</a></li>
      	    <li ><a href="messages.php#scroll">Message<?php $message = massenger::unseen(); if($message){ echo '('.COUNT($message).')'; } ?></a></li>
            <li ><a href="notification.php">notification</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                setting<span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="edit_profile.php">Setting</a></li>
                <li><a href="?action=logout">Log out</a></li>
              </ul>
            </li>
            <li><a href="#" class="nav-controller"><i class="fa fa-user"></i></a></li>
          </ul>
        </div>
      </div>
    </nav>
