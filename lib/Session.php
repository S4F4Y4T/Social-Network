<?php
   class Session{

     public static function isloggedin(){

       if( isset($_COOKIE['SNID']) ){
         $data = array(
       		'table'			 => array('table' => 'login_tokens'),
       		'selectcond' => array('select' => '*'),
           'limit' 	   => array('start' => 1),
           'wherecond'  => array('where' =>array('token' => sha1($_COOKIE['SNID'])))
       	);
         $query = DB::fetch($data);

         if( isset($_COOKIE['SNID_'])){

           if( $query ){
             return $query[0]['user_id'];
           }


         } else {

           if( $query ){



           $cstrong = true;
           $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

           $table ="login_tokens";
           $data = array(
             'user_id'     => $query[0]['user_id'],
             'token' => sha1($token),
           );

           DB::insertdata($data,$table);

           $cookie = setcookie('SNID', $token , time() + 60 * 60 * 24 * 7 , '/' , NULL , NULL , TRUE );
           $cookie = setcookie('SNID_', 1 , time() + 60 * 60 * 24 , '/' , NULL , NULL , TRUE );

           $delete = array(
             'table'			 => array('table' => 'login_tokens'),
             'wherecond'  => array('where' =>array('token' => sha1($_COOKIE['SNID'])))
           );

           DB::delete($delete);

         }

        }

       }
       return false;
     }

     public static function chklogin(){
       if( self::isloggedin() ){
         header('Location: home.php');
       }
     }
     
     public static function chklogout(){
       if( !self::isloggedin() ){
         header('Location: /');
       }
     }

     public static function logout(){
       if(isset($_COOKIE['SNID'])){
         $data = array(
           'table'			 => array('table' => 'login_tokens'),
       		'wherecond'  => array('where' =>array('token' => sha1($_COOKIE['SNID'])))
       	);
        DB::delete($data);
        $cookie = setcookie('SNID', 1 , time() - 60 * 60 * 24 * 7 , '/' , NULL , NULL , TRUE );
        $cookie = setcookie('SNID_', 0 , time() - 60 * 60 * 24 * 7 , '/' , NULL , NULL , TRUE );
        header("Location: /");
      }else{
        header("Location: /");
      }
     }

	  public static function init(){
		  if( version_compare(phpversion(), '5.4.0', '<' )){
			  if( session_id() == '' ){
				  session_start();
			  }
  	  } else {
  		  if( session_status() == PHP_SESSION_NONE ){
  			  session_start();
  		  }
  	  }
  	  }

	  public static function set($key, $val){
		  $_SESSION[$key] = $val;
	  }

	  public static function get($key){
		  if(isset($_SESSION[$key])){
			  return $_SESSION[$key];
	  }else{
		  return false;
	  }
	  }

    public static function destroy(){
      session_unset();
      session_destroy();
    }

   }

?>
