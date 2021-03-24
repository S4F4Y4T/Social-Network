<?php 
class fetchposts{
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
}