<?php
class comment{
  public function __construct(){
    //echo '<script>window.alert(1)</script>';
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

}