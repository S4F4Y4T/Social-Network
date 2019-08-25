<?php
class timeline{
  public function __construct(){
    //echo '<script>window.alert(1)</script>';
  }

  public static function isUser(){
    if(isset($_GET['username'])){
      $user = $_GET['username'];

      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'wherecond'  => array('where' =>array('username' => $user))
      );

      $query = DB::fetch($data);

      if($query){
        if( validation::verify( $query[0]['id'],Session::isloggedin() ) ){
          return true;
        }
      }
    } else {

      return true;

    }
  }

  public static function post($data){
    if(isset($_POST['csrf'])){
      if($_POST['csrf'] == Session::get('csrf')){

        if(!empty($_FILES['image']['name']) AND !empty($data['body'])){
          $name   = $_FILES["image"]["name"];
          $size		= $_FILES["image"]["size"];
          $tmpname= $_FILES["image"]["tmp_name"];

          $extention = explode('.',$name);
          $extention = strtolower(end($extention));
          $uniqname  = substr(md5(time()),0 , 10).'.'.$extention;

          validation::size($size)::extention($extention)::emptyfiles($name);
          validation::post($data,'body')::xss()::isempty();

          if(validation::submit()){
            $destination_path = getcwd().DIRECTORY_SEPARATOR;
            //$upload = 'images/profile/' . $uniqname;
            $upload = 'images/others/'.$uniqname;
            $body = validation::$value['body'];
            $body = nl2br($_REQUEST['body']);
            $body = helper::mention($body);

            move_uploaded_file($tmpname , $upload);

            $table ="post";

            $data = array(
              'user_id' => Session::isloggedin(),
              'body'    => $body,
              'post_image'   => $uniqname
            );

            DB::insertdata($data,$table);

          } else {
            return validation::$error;
          }
        } else if(!empty($_FILES['image']['name'])){
          $name   = $_FILES["image"]["name"];
          $size		= $_FILES["image"]["size"];
          $tmpname= $_FILES["image"]["tmp_name"];

          $extention = explode('.',$name);
          $extention = strtolower(end($extention));
          $uniqname  = substr(md5(time()),0 , 10).'.'.$extention;

          validation::size($size)::extention($extention)::emptyfiles($name);

          if(validation::submit()){
            $upload = 'images/others/'.$uniqname;

            move_uploaded_file($tmpname , $upload);

            $table ="post";

            $data = array(
              'user_id' => Session::isloggedin(),
              'post_image'   => $uniqname
            );
            DB::insertdata($data,$table);

          } else {
            return validation::$error;
          }
        }else{
          validation::post($data,'body')::xss()::isempty();

          if(validation::submit()){
            $body = validation::$value['body'];
            $body = nl2br($_REQUEST['body']);
            $body = helper::mention($body,$type=2);
            $table ="post";

            $data = array(
              'user_id' => Session::isloggedin(),
              'body'    => $body
            );

            DB::insertdata($data,$table);

          } else {
            return validation::$error;
          }
        }

      }
      Session::destroy();
      header("Location:profile.php");
    }
  }

  public static function fetchpost(){
    if(isset($_GET['username'])){
      $user = $_GET['username'];

      $data = array(
  		    'wherecond'  => array('where'  =>array('username' => $user))
    	);
      $sql = 'SELECT post.*,users.* FROM post JOIN users ON post.user_id = users.id WHERE username=:username ORDER BY post_id DESC';

      return $query = DB::fetchbyquery($sql,$data);

    } else {

      $data = array(
  		    'wherecond'  => array('where'  =>array('id' => Session::isloggedin()))
    	);
      $sql = 'SELECT post.*,users.* FROM post JOIN users ON post.user_id = users.id WHERE id=:id ORDER BY post_id DESC';
      return $query = DB::fetchbyquery($sql,$data);
   }

  }

  public static function timelinepost(){
      //$sql = 'SELECT post.*,followers.*,users.* FROM post,followers,users where post.user_id = followers.following_id AND followers.user_id = '.Session::isloggedin().' AND users.id = followers.following_id ORDER BY post_id DESC';
      $sql = 'SELECT post.*,followers.*,users.* FROM followers JOIN users JOIN post ON post.user_id = followers.following_id AND followers.user_id = '.Session::isloggedin().' AND users.id = followers.following_id ORDER BY post_id DESC';
      return $query = DB::fetchbyquery($sql,$data=array());
  }

  public static function like($data){
    if(isset($_POST['csrf'])){
      if($_POST['csrf'] == Session::get('csrf')){

        $post_like = array(
          'table'			 => array('table' => 'post'),
          'selectcond' => array('select' => '*'),
          'wherecond'  => array('where' =>array('post_id' => $data['post_id']))
        );

        $likes = array(
          'table'			 => array('table' => 'likes'),
          'selectcond' => array('select' => '*'),
          'wherecond'  => array('where' =>array('user_id' => Session::isloggedin() ,'post_id' => $data['post_id']))
        );
        $likes = DB::fetch($likes);

        if( !$likes ){
          $data = array(
            'post_id'  => $data['post_id'],
            'user_id'  => Session::isloggedin()
          );
          $table = 'likes';
          $insert = DB::insertdata($data,$table);

          if( $insert ){

            $requr = array(
              'table'			 => array('table' => 'post'),
              'wherecond'  => array('where' =>array('post_id' => $data['post_id']))
            );
            $post_data = array(
              'likes' => 1+DB::fetch($post_like)[0]['likes']
            );


            DB::update($post_data,$requr);
            header("Location:#".$data['post_id']);
          }

          //notification section
          $sql = 'select user_id from post where post.post_id = '.$data['post_id'].' LIMIT 1';

          $receiver = DB::fetchbyquery($sql,$data);

          $table ="notification";
          $data = array(
            'type'     => 4,
            'sender'   => Session::isloggedin(),
            'receiver' => $receiver[0]['user_id'],
            'post' => $data['post_id']
          );
          if($receiver[0]['user_id'] != Session::isloggedin()){
            $noti = DB::insertdata($data,$table);
          }
          //notification section


        } else {
          $delete = array(
            'table'			 => array('table' => 'likes'),
            'wherecond'  => array('where' =>array('user_id' => Session::isloggedin() ,'post_id' => $data['post_id']))
          );

          $delete = DB::delete($delete);

          if( $delete ){
            $requr = array(
              'table'			 => array('table' => 'post'),
              'wherecond'  => array('where' =>array('post_id' => $data['post_id']))
            );
            $post_data = array(
              'likes' => DB::fetch($post_like)[0]['likes']-1
            );

            DB::update($post_data,$requr);
            header("Location:#".$data['post_id']);
          }
        }

      }
      Session::destroy();
    }
  }

  public static function isliked($postid){
    $liked = array(
      'table'			 => array('table' => 'likes'),
      'selectcond' => array('select' => '*'),
      'wherecond'  => array('where' =>array('user_id' => Session::isloggedin() ,'post_id' => $postid))
    );

    $likes = DB::fetch($liked);

    if( !$likes ){
      echo '<button name="like" type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>Like</button>';
    } else {
      echo '<button name="like" type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>Unlike</button>';
    }
  }

  public static function comment($data){
    if(isset($_POST['csrf'])){
      if($_POST['csrf'] == Session::get('csrf')){

        validation::post($data,'comment')::xss()::isempty();

        if( validation::submit() ){
          $comment = validation::$value['comment'];
          $comment =  helper::mention($comment,$type=3,$data);

          $table ="comments";

          $com_data = array(
            'user_id' => Session::isloggedin(),
            'comment'    => $comment,
            'post_id'   => $data['post_id']
          );

          $insert = DB::insertdata($com_data,$table);

          if($insert){
            $post_comment = array(
              'table'			 => array('table' => 'post'),
              'selectcond' => array('select' => '*'),
              'wherecond'  => array('where' =>array('post_id' => $data['post_id']))
            );

            $requr = array(
              'table'			 => array('table' => 'post'),
              'wherecond'  => array('where' =>array('post_id' => $data['post_id']))
            );
            $post_data = array(
              'comments' => 1+DB::fetch($post_comment)[0]['comments']
            );

            DB::update($post_data,$requr);
            header("Location:#".$data['post_id']);
          }

          //notification section
          $sql = 'select user_id from post where post.post_id = '.$data['post_id'].' LIMIT 1';

          $receiver = DB::fetchbyquery($sql,$data);

          $table ="notification";
          $data = array(
            'type'     => 5,
            'sender'   => Session::isloggedin(),
            'receiver' => $receiver[0]['user_id'],
            'post' => $data['post_id']
          );
          if($receiver[0]['user_id'] != Session::isloggedin()){
            $noti = DB::insertdata($data,$table);
          }
          //notification section

        } else {
          return validation::$error;
        }
        
      }
      Session::destroy();
    }
  }

  public static function fetchcomment($data){
    $data = array(
		    'wherecond'  => array('where'  =>array('post_id' => $data))
  	);
    $sql = 'SELECT comments.*,users.* FROM comments JOIN users ON comments.user_id = users.id WHERE post_id=:post_id ORDER BY posted_at_com ASC';

    return $query = DB::fetchbyquery($sql,$data);
  }

  /*public function notification(){
    $sql = 'SELECT users.*,notification.* FROM notification JOIN users ON notification.sender = users.id WHERE receiver='.Session::isloggedin().' ORDER BY receiver DESC';

    return $query = DB::fetchbyquery($sql);
  }*/

  public static function notification(){
    $data = array(
        'wherecond'  => array('where'  =>array('receiver' => Session::isloggedin()))
    );
    $sql = 'SELECT notification.*,users.* FROM notification JOIN users ON notification.sender = users.id WHERE receiver=:receiver ORDER BY date DESC';

    return $query = DB::fetchbyquery($sql,$data);
  }

  public static function photos(){
    if(isset($_GET['username'])){
      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'limit' 	   => array('start' => 1),
        'wherecond'  => array('where' =>array('username' => $_GET['username']))
      );

      $query = DB::fetch($data);
      if($query){
        $data = array(
      		'table'			 => array('table' => 'post'),
      		'pkey'			 => array('pkey' => 'post_id'),
      		'selectcond' => array('select' => '*'),
      		'orderby'	   => array('order' => 'DESC'),
      		'query' 	 	 => array('query' => 'user_id=:user_id AND post_image !="" '),
      		'wherecond'=> array('where' =>array('user_id' => $query[0]['id']))
      	);
        return DB::fetch($data);
      }

    }else{
      $data = array(
    		'table'			 => array('table' => 'post'),
    		'pkey'			 => array('pkey' => 'post_id'),
    		'selectcond' => array('select' => '*'),
    		'orderby'	   => array('order' => 'DESC'),
    		'query' 	 	 => array('query' => 'user_id=:user_id AND post_image !="" '),
    		'wherecond'=> array('where' =>array('user_id' => Session::isloggedin()))
    	);
      return DB::fetch($data);
    }

  }

  public static function timelinephotos(){
    if(isset($_GET['username'])){
      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'limit' 	   => array('start' => 1),
        'wherecond'  => array('where' =>array('username' => $_GET['username']))
      );

      $query = DB::fetch($data);
      if($query){
        $data = array(
      		'table'			 => array('table' => 'post'),
      		'pkey'			 => array('pkey' => 'post_id'),
      		'selectcond' => array('select' => '*'),
      		'orderby'	   => array('order' => 'DESC'),
          'limit' 	   => array('start' => 10),
      		'query' 	 	 => array('query' => 'user_id=:user_id AND post_image !="" '),
      		'wherecond'=> array('where' =>array('user_id' => $query[0]['id']))
      	);
        return DB::fetch($data);
      }

    }else{
      $data = array(
    		'table'			 => array('table' => 'post'),
    		'pkey'			 => array('pkey' => 'post_id'),
    		'selectcond' => array('select' => '*'),
    		'orderby'	   => array('order' => 'DESC'),
        'limit' 	   => array('start' => 10),
    		'query' 	 	 => array('query' => 'user_id=:user_id AND post_image !="" '),
    		'wherecond'=> array('where' =>array('user_id' => Session::isloggedin()))
    	);
      return DB::fetch($data);
    }

  }


}
?>
