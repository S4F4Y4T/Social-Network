<?php
class userprofile{

  public function __construct(){
  }

  public static function profile(){
    if(isset($_GET['username'])){
      $user = $_GET['username'];

      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'limit' 	   => array('start' => 1),
        'wherecond'  => array('where' =>array('username' => $user))
      );

      $query = DB::fetch($data);
      if($query){
        return $query;
      }else{
        header("Location:profile.php");
      }
    } else {
      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'limit' 	   => array('start' => 1),
        'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
      );

      return $query = DB::fetch($data);
    }
  }

  public static function username(){
    $data = array(
      'table'			 => array('table' => 'users'),
      'selectcond' => array('select' => 'username'),
      'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
    );

    return DB::fetch($data);
  }

  public static function search(){
    if($_GET['q']){
      $q = $_GET['q'];
      $data = array(
        		'table'			 => array('table' => 'users'),
        		//'pkey'			 => array('pkey' => 'catid'),
        		'selectcond' => array('select' => '*'),
        		//'orderby'	   => array('order' => 'DESC'),
        		//'limit' 	 => array('start' => 2,'limit' => 3),
        		'search'    => 'search',
        		'wherecond'=> array('where' =>array('name' => $q,'username' => $q))
        	);
      return $query = DB::fetch($data);
    } else {
      header("Location:home.php");
    }
  }

  public static function follow(){
    $data = array(
      'table'			 => array('table' => 'followers'),
      'selectcond' => array('select' => '*'),
      'wherecond'  => array('where' =>array('user_id' => Session::isloggedin() ,'following_id' => $_POST['receiver']))
    );

    $following = DB::fetch($data);

    if( !$following ){
      if( !validation::verify( $_POST['receiver'],Session::isloggedin() ) ){
        $table ="followers";
        $data = array(
          'following_id'  => $_POST['receiver'],
          'user_id'       => Session::isloggedin()
        );

        $insert = DB::insertdata($data,$table);
        if($insert){
          $table ="notification";
          $data = array(
            'type'     => 1,
            'sender'   => Session::isloggedin(),
            'receiver' => $_POST['receiver']
          );

          $insert = DB::insertdata($data,$table);
        }
      }
    } else {
      $delete = array(
        'table'			 => array('table' => 'followers'),
        'wherecond'  => array('where' =>array('user_id' => Session::isloggedin() ,'following_id' => $_POST['receiver']))
      );

      DB::delete($delete);
    }
  }

  public static function isfollowing(){
    if(isset($_GET['username'])){
      $user = $_GET['username'];

      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'wherecond'  => array('where' =>array('username' => $user))
      );

      $query = DB::fetch($data);

      if($query){
        if( !validation::verify( $query[0]['id'],Session::isloggedin() ) ){
          $data = array(
            'table'			 => array('table' => 'followers'),
            'selectcond' => array('select' => '*'),
            'wherecond'  => array('where' =>array('user_id' => Session::isloggedin() ,'following_id' => $query[0]['id']))
          );

          $following = DB::fetch($data);

          if( !$following ){
            return "
              <button type='submit'name='follow' class='btn btn-azure'>Follow</button>
              <button type='submit' name='inbox' class='btn btn-azure'>Message</button>
              <input type='hidden' name='receiver'value='".$query[0]['id']."'>
            ";
          } else {
            return "
              <button type='submit' name='follow' class='btn btn-azure'>Unfollow</button>
              <button type='submit' name='inbox' class='btn btn-azure'>Message</button>
              <input type='hidden' name='receiver'value='".$query[0]['id']."'>
            ";
          }
        }
      }
    }
  }

  public static function suggestpeople(){
    $followers = 'SELECT GROUP_CONCAT(users.id) as count
    FROM followers
    JOIN users ON users.id = followers.following_id
    AND followers.user_id = '.Session::isloggedin();

    $followers = DB::fetchbyquery($followers);

    if($followers[0]['count'] ){

      $sql = 'SELECT users.*
      FROM followers
      JOIN users ON users.id = followers.following_id
      AND followers.user_id in ( '.$followers[0]['count'].' )
      AND users.id NOT IN ( '.$followers[0]['count'].' )
      ORDER BY id DESC LIMIT 10';

      $query = DB::fetchbyquery($sql,$data=array());
      if($query){
        return $query;
      }else{
        $sql = 'SELECT users.*
        FROM users
        WHERE users.id NOT IN ( '.$followers[0]['count'].' )
        ORDER BY id DESC LIMIT 10';

        return $query = DB::fetchbyquery($sql,$data=array());
      }
    }
  }

  public static function suggestlimit($user){
    if(!$user==''){
     if(COUNT($user) < 10){
        $limit = 10-COUNT($user);

        $followers = 'SELECT GROUP_CONCAT(users.id) as count
        FROM followers
        JOIN users ON users.id = followers.following_id
        AND followers.user_id = '.Session::isloggedin();

        $followers = DB::fetchbyquery($followers);

        if( $followers[0]['count'] ){

          $sql = 'SELECT GROUP_CONCAT(users.id) as count
          FROM followers
          JOIN users ON users.id = followers.following_id
          AND followers.user_id in ( '.$followers[0]['count'].' )
          AND users.id NOT IN ( '.$followers[0]['count'].' )
          ';
          $query = DB::fetchbyquery($sql);

          if($query[0]['count']){
            $stmt = 'SELECT users.*
            FROM users
            WHERE users.id NOT IN ( '.$followers[0]['count'].' )
            AND users.id NOT IN ( '.$query[0]['count'].' )
            ORDER BY id DESC LIMIT '.$limit;

            $result = DB::fetchbyquery($stmt,$data=array());
            if($result){
              return $result;
            }
         }
       }
     }
   } else {
     $sql = 'SELECT users.*
     FROM users
     ORDER BY id DESC LIMIT 10';
     return $query = DB::fetchbyquery($sql,$data=array());
   }
  }

  public static function following(){
    if(isset($_GET['username'])){
      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'limit' 	   => array('start' => 1),
        'wherecond'  => array('where' =>array('username' => $_GET['username']))
      );

      $query = DB::fetch($data);
      if($query){
        $sql = 'SELECT users.*
        FROM followers
        JOIN users ON users.id = followers.following_id
        AND followers.user_id = '.$query[0]['id'].' ORDER BY id DESC';

        return $query = DB::fetchbyquery($sql,$data=array());
      }

    }else{
      $sql = 'SELECT users.*
      FROM followers
      JOIN users ON users.id = followers.following_id
      AND followers.user_id = '.Session::isloggedin().' ORDER BY id DESC';

      return $query = DB::fetchbyquery($sql,$data=array());
    }

  }

  public static function follower(){
    if(isset($_GET['username'])){
      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'limit' 	   => array('start' => 1),
        'wherecond'  => array('where' =>array('username' => $_GET['username']))
      );

      $query = DB::fetch($data);
      if($query){
        $sql = 'SELECT users.*
        FROM followers
        JOIN users ON users.id = followers.user_id
        AND followers.following_id = '.$query[0]['id'].' ORDER BY id DESC ';

        return $query = DB::fetchbyquery($sql,$data=array());
      }

    }else{
      $sql = 'SELECT users.*
      FROM followers
      JOIN users ON users.id = followers.user_id
      AND followers.following_id = '.Session::isloggedin().' ORDER BY id DESC ';

      return $query = DB::fetchbyquery($sql,$data=array());
    }

  }
  public static function timelinefollower(){
    if(isset($_GET['username'])){
      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'limit' 	   => array('start' => 10),
        'wherecond'  => array('where' =>array('username' => $_GET['username']))
      );

      $query = DB::fetch($data);
      if($query){
        $sql = 'SELECT users.*
        FROM followers
        JOIN users ON users.id = followers.user_id
        AND followers.following_id = '.$query[0]['id'].' ORDER BY id DESC LIMIT 10';

        return $query = DB::fetchbyquery($sql,$data=array());
      }

    }else{
      $sql = 'SELECT users.*
      FROM followers
      JOIN users ON users.id = followers.user_id
      AND followers.following_id = '.Session::isloggedin().' ORDER BY id DESC LIMIT 10';

      return $query = DB::fetchbyquery($sql,$data=array());
    }

  }

  public static function profileimage($data){
    if(!empty($_FILES['avatar']['name']) AND !empty($_FILES['cover']['name'])){
      $avatarname   = $_FILES["avatar"]["name"];
      $avatarsize		= $_FILES["avatar"]["size"];
      $avatartmpname= $_FILES["avatar"]["tmp_name"];

      $covername   = $_FILES["cover"]["name"];
      $coversize	 = $_FILES["cover"]["size"];
      $covertmpname= $_FILES["cover"]["tmp_name"];

      $avatarextention = explode('.',$avatarname);
      $avatarextention = strtolower(end($avatarextention));
      $avataruniqname  = substr(md5(time()),0 , 10).'.'.$avatarextention;

      $coverextention = explode('.',$covername);
      $coverextention = strtolower(end($coverextention));
      $coveruniqname  = substr(sha1(time()),0 , 10).'.'.$coverextention;

      validation::size($avatarsize)::extention($avatarextention)::emptyfiles($avatarname);
      validation::size($coversize)::extention($coverextention)::emptyfiles($covername);

      if(validation::submit()){
        $destination_path = getcwd().DIRECTORY_SEPARATOR;
        //$upload = 'images/profile/' . $uniqname;
        $avatarupload = 'images/profile/'.$avataruniqname;
        $coverupload  = 'images/cover/'.$coveruniqname;

        move_uploaded_file($avatartmpname , $avatarupload);
        move_uploaded_file($covertmpname , $coverupload);

        $data = array(
          'table'			 => array('table' => 'users'),
          'selectcond' => array('select' => '*'),
          'limit' 	   => array('start' => 1),
          'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
        );

        if( DB::fetch($data)[0]['image'] != 'profile.png' ){

          $delete = unlink('images/profile/'.DB::fetch($data)[0]['image']);

        } else if ( DB::fetch($data)[0]['image'] != 'cover.png' ){

          $delete = unlink('images/cover/'.DB::fetch($data)[0]['cover']);

        }

        $requr = array(
          'table'			 => array('table' => 'users'),
          'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
        );

        $data = array(
          'image' => $avataruniqname,
          'cover' => $coveruniqname
        );

        DB::update($data,$requr);

        header("Location:profile.php");

      } else {
        return validation::$error;
      }
    } else if(!empty($_FILES['avatar']['name'])){
      $name   = $_FILES["avatar"]["name"];
      $size		= $_FILES["avatar"]["size"];
      $tmpname= $_FILES["avatar"]["tmp_name"];

      $extention = explode('.',$name);
      $extention = strtolower(end($extention));
      $uniqname  = substr(md5(time()),0 , 10).'.'.$extention;

      validation::size($size)::extention($extention)::emptyfiles($name);

      if(validation::submit()){
        $destination_path = getcwd().DIRECTORY_SEPARATOR;
        //$upload = 'images/profile/' . $uniqname;
        $upload = 'images/profile/'.$uniqname;

        move_uploaded_file($tmpname , $upload);

        $data = array(
          'table'			 => array('table' => 'users'),
          'selectcond' => array('select' => '*'),
          'limit' 	   => array('start' => 1),
          'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
        );

        if(DB::fetch($data)[0]['image'] != 'profile.png'){
          $delete = unlink('images/profile/'.DB::fetch($data)[0]['image']);
        }


        $requr = array(
          'table'			 => array('table' => 'users'),
          'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
        );

        $data = array(
          'image' => $uniqname
        );

        DB::update($data,$requr);

        header("Location:profile.php");

      } else {
        return validation::$error;
      }
    } else if(!empty($_FILES['cover']['name'])){
      $name   = $_FILES["cover"]["name"];
      $size		= $_FILES["cover"]["size"];
      $tmpname= $_FILES["cover"]["tmp_name"];

      $extention = explode('.',$name);
      $extention = strtolower(end($extention));
      $uniqname  = substr(md5(time()),0 , 10).'.'.$extention;

      validation::size($size)::extention($extention)::emptyfiles($name);

      if(validation::submit()){
        $destination_path = getcwd().DIRECTORY_SEPARATOR;
        //$upload = 'images/profile/' . $uniqname;
        $upload = 'images/cover/'.$uniqname;

        move_uploaded_file($tmpname , $upload);

        $data = array(
          'table'			 => array('table' => 'users'),
          'selectcond' => array('select' => '*'),
          'limit' 	   => array('start' => 1),
          'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
        );

        if(DB::fetch($data)[0]['cover'] != 'cover.png'){
          $delete = unlink('images/cover/'.DB::fetch($data)[0]['cover']);
        }


        $requr = array(
          'table'			 => array('table' => 'users'),
          'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
        );

        $data = array(
          'cover' => $uniqname
        );
        DB::update($data,$requr);

        header("Location:profile.php");

      } else {
        return validation::$error;
      }
    }
  }

  public static function about($data){
    validation::post($data,'Name')::xss()::length(3,32)::isempty();
    validation::post($data,'Birthdate')::xss()::length(3,32)::isempty();
    validation::post($data,'Gender')::xss()::length(3,32)::isempty();
    validation::post($data,'Job')::xss()::length(3,32)::isempty();
    validation::post($data,'Address')::xss()::length(3,32)::isempty();
    validation::post($data,'Bio')::xss()::length(3,150)::isempty();

    if(validation::submit()){

      $name    = validation::$value['Name'];
      $bday    = validation::$value['Birthdate'];
      $gender  = validation::$value['Gender'];
      $job     = validation::$value['Job'];
      $address = validation::$value['Address'];
      $about   = validation::$value['Bio'];

      $requr = array(
        'table'			 => array('table' => 'users'),
        'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
      );

      $data = array(
        'name' => ucwords($name),
        'birthdate' => $bday,
        'gender' => $gender,
        'job' => $job,
        'address' => $address,
        'about'   => $about
      );

      $update = DB::update($data,$requr);
      if($update){
        return '<div class="alert alert-info">Information Change Successfully</div>';
      }
    } else {
      return validation::$error;
    }
  }

}
?>
