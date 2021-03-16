<?php class massenger{
  public function __construct(){
    //echo '<script>window.alert(1)</script>';
  }

  public static function send($data){
    validation::post($data,'body')::xss()::isempty();
    validation::post($data,'receiver')::xss()::isempty();

    if(validation::submit()){
      $body = validation::$value['body'];
      $receiver = validation::$value['receiver'];
      $table ="messages";

      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'wherecond'  => array('where' =>array('id' => $receiver))
      );

      $query = DB::fetch($data);
      if($query && ($receiver != Session::isloggedin())){
        $send = array(
          'receiver' => $receiver,
          'sender'   => Session::isloggedin(),
          'message'  => $body
        );

        $send = DB::insertdata($send,$table);
        if($send){
          if(isset($_GET['receiver']) AND !empty($_GET['receiver'])){

            header("Location:?receiver=".$_GET['receiver']."#scroll");
          }
        }
      }

    } else {
      return validation::$error;
    }
  }

  public static function list(){

    if(isset($_GET['receiver']) AND !empty($_GET['receiver'])){
      $receiver = $_GET['receiver'];
      $data = array(
        'table'			 => array('table' => 'users'),
        'selectcond' => array('select' => '*'),
        'wherecond'  => array('where' =>array('id' => $_GET['receiver']))
      );
      $query = DB::fetch($data);
      if($query){
        if($_GET['receiver'] != Session::isloggedin()){

          $requr = array(
            'table'			 => array('table' => 'messages'),
            'wherecond'  => array('where' =>array('sender' => $_GET['receiver'] ,'receiver' => Session::isloggedin()))
          );
          $post_data = array(
            'seen' => 1
          );


          DB::update($post_data,$requr);


          $data = array(
              'wherecond'  => array('where'  =>array('receiver' => Session::isloggedin()))
          );
          $sql = 'SELECT DISTINCT users.* FROM messages JOIN users ON messages.sender = users.id OR messages.receiver = users.id WHERE users.id != '.Session::isloggedin().' AND (sender=:receiver OR receiver=:receiver) ORDER BY id DESC';

          $query = DB::fetchbyquery($sql,$data);
          if($query){
            return $query;
          }
        } else {
          $data = array(
              'wherecond'  => array('where'  =>array('receiver' => Session::isloggedin()))
          );
          $sql = 'SELECT users.* FROM messages JOIN users ON messages.sender = users.id WHERE users.id != '.Session::isloggedin().' AND (receiver=:receiver OR sender=:receiver) ORDER BY id DESC LIMIT 1';


          $query = DB::fetchbyquery($sql,$data);
          if($query){
            header("Location:?receiver=".$query[0]['id']."#scroll");
          }
        }


      }else{
        $data = array(
            'wherecond'  => array('where'  =>array('receiver' => Session::isloggedin()))
        );
        $sql = 'SELECT users.* FROM messages JOIN users ON messages.sender = users.id WHERE users.id != '.Session::isloggedin().' AND (receiver=:receiver OR sender=:receiver) ORDER BY id DESC LIMIT 1';


        $query = DB::fetchbyquery($sql,$data);
        if($query){
          header("Location:?receiver=".$query[0]['id']."#scroll");
        }
      }

    }else{
      $data = array(
          'wherecond'  => array('where'  =>array('receiver' => Session::isloggedin()))
      );
      $sql = 'SELECT users.* FROM messages JOIN users ON messages.sender = users.id WHERE users.id != '.Session::isloggedin().' AND (receiver=:receiver OR sender=:receiver) ORDER BY id DESC LIMIT 1';

      $query = DB::fetchbyquery($sql,$data);
      if($query){
        header("Location:?receiver=".$query[0]['id']."#scroll");
      }
    }
  }

  public static function read(){
    $receiver = isset($_GET['receiver']);

    $data = array(
        'wherecond'  => array('where'  =>array('sender' => $receiver, 'receiver' => Session::isloggedin()))
    );
    $sql = 'SELECT messages.*,s.username as Sender,r.username as Receiver,s.image as image
            FROM messages
            JOIN users s ON messages.sender = s.id
            JOIN users r ON messages.receiver= r.id
            WHERE (sender=:sender AND receiver=:receiver) OR (sender=:receiver AND receiver=:sender)';
    return $query = DB::fetchbyquery($sql,$data);
  }

  public static function unseen(){
    $data = array(
        'wherecond'  => array('where'  =>array('receiver' => Session::isloggedin()))
    );
    $sql = 'SELECT DISTINCT users.id FROM messages JOIN users ON messages.sender = users.id WHERE users.id != '.Session::isloggedin().' AND messages.receiver = '.Session::isloggedin().' AND seen=0 ';
    $query = DB::fetchbyquery($sql,$data);

    if($query){
      return $query;
    }
  }

  public static function message($id){
    $data = array(
        'wherecond'  => array('where'  =>array('sender' => $id, 'receiver' => Session::isloggedin()))
    );
    $sql = 'SELECT messages.*
            FROM messages
            WHERE (sender=:sender AND receiver=:receiver) OR (sender=:receiver AND receiver=:sender)
            ORDER BY date DESC LIMIT 1';

    return $query = DB::fetchbyquery($sql,$data);
  }



}
?>
