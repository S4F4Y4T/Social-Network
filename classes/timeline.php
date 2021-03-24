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
			exit();
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

  

  


}
?>
