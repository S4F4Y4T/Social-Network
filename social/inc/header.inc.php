<?php
  error_reporting(0);
  include_once "./config/config.php";
  include_once'classes/user.php';

  spl_autoload_register(function($class){
    include'lib/'.$class.'.php';
  });

   //set headers to NOT cache a page
   header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
   header("Pragma: no-cache"); //HTTP 1.0
   header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
   // Date in the past

   $cstrong  = true;
   $token    = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
   Session::init();
   Session::set('token',$token);
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
    <title>DayDay</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome.4.6.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/login_register.css?v=1" rel="stylesheet">
    <link href="assets/css/forms.css" rel="stylesheet">
    <link href="assets/css/buttons.css" rel="stylesheet">
    <script src="assets/js/jquery.1.11.1.min.js"></script>
    <script src="assets/bootstrap.3.3.6/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>


  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-fixed-top navbar-transparent" role="navigation">
        <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button id="menu-toggle" type="button" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar bar1"></span>
            <span class="icon-bar bar2"></span>
            <span class="icon-bar bar3"></span>
          </button>
          <a class="navbar-brand" href="/">Day-Day</a>
        </div>
      </div>
    </nav>
