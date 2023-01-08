<?php
class user{
    public function __construct(){
    }

    public static function active(){
      $requr = array(
        'table'			 => array('table' => 'active'),
        'wherecond'  => array('where' =>array('userid' => Session::isloggedin()))
      );

      $data = array(
        'time' => time()
      );

      DB::update($data,$requr);
    }

    public static function onlineusers(){
      $sql = 'SELECT users.*
      FROM users
      JOIN active
      ON active.userid = users.id
      JOIN followers
      WHERE followers.user_id = '.Session::isloggedin().'
      AND followers.following_id = users.id AND users.id != '.Session::isloggedin().'
      AND active.time > '.time().' -60*5  ORDER BY time DESC';

      return $query = DB::fetchbyquery($sql);
    }

    public static function registration( $data ){
      if($_POST){
        validation::post($data,'Name')::xss()::length(3,32)::isempty();
        validation::post($data,'Username')::xss()::username()::length(3,32)::isempty();
        validation::post($data,'Email')::xss()::length(3,32)::isempty()::email();
        validation::post($data,'Password')::xss()::length(8,64)::isempty()::password();
        validation::post($data,'Re-password')::xss()::isempty();

        if( validation::submit() ){
          $name   = validation::$value['Name'];
          $user   = validation::$value['Username'];
          $email  = validation::$value['Email'];
          $pass   = validation::$value['Password'];
          $repass = validation::$value['Re-password'];

          $data = array(
        		'table'			 => array('table' => 'users'),
        		'selectcond' => array('select' => '*'),
            'limit' 	   => array('start' => 1),
            'query'      => array('query' => '(username=:username OR email=:email) AND active =:active'),
            'wherecond'  => array('where' =>array('username' => $user, 'email' => $email, 'active' => 1))
        	);

          $query = DB::fetch($data);

          if($query){
            foreach($query as $value){
              $username = $value['username'];
              $dbemail  = $value['email'];
            }
          }

          if( validation::verify($pass,$repass) ){
            if( !validation::verify(isset($username),$user) ){
              if( !validation::verify(isset($dbemail),$email)){
                $cstrong  = true;
                $token    = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                $ver_code = substr(md5(rand(1,8)), 0, 8);
                $exp_date = time() + 1800;

                  $data = array(
                    'name'     => ucwords($name),
                    'username' => $user,
                    'email'    => $email,
                    'password' => validation::encrypt($pass)
                  );

                  $table ="users";
                  $table_ver ="verf_token";

                  $ver_data = array(
                    'email'     => $email,
                    'verf_code' => $ver_code,
                    'token'     => sha1($token),
                    'exp_date'  => $exp_date
                  );
                  $registration = DB::insertdata($data,$table);
                  $varification = DB::insertdata($ver_data,$table_ver);

                  if( $registration ){

                    $message  = "welcome to our family.To become our permanent member use the code from below to varification your account</br>";
                    $message .= "<B><h3>".$ver_code."</h3></B></br>";
                    $message .= "Or you can use this link to reset your password as well:<br>";
                    $message .= "<a href='".BASE."/mailver.inc.php?token=".$token."'><b>Click Here</b></a><br>";
                    $message .= "This code will be valid only for 30 minutes</br>";
                    helper::mail($email,$message);

                    return ['status' => true, 'message' => $message];

                  } else {
                    header("Location:".BASE."?msg=".urlencode(serialize('<div class="alert alert-danger">Error!Something Went Wrong</div>')));
                  }
                } else {
                  header("Location:".BASE."?msg=".urlencode(serialize('<div class="alert alert-danger">Email Already In Use</div>')));
                }
            } else {
              header("Location:".BASE."?msg=".urlencode(serialize('<div class="alert alert-danger">Username Already Taken</div>')));
            }
          } else {
            header("Location:".BASE."?msg=".urlencode(serialize('<div class="alert alert-danger">Confirmation Password Did not Match</div>')));
          }
        } else {
          header("Location:".BASE."?msg=".urlencode(serialize(validation::$error)));
        }
      } else {
        header("Location:".BASE."");
      }
    }

    public function mailverification($data){

      if( ($_POST['ver_code']) OR ($_GET['token']) ) {
        if( $_POST['ver_code'] ) {
            validation::post($_POST,'ver_code')::xss();
            $code   = validation::$value['ver_code'];
            $token  = '';

        } else if ($_GET['token']) {
            validation::post($_GET,'token')::xss();
            $token   = validation::$value['token'];
            $code  = '';
        }

        $current = time();
        $data = array(
          'table'			 => array('table' => 'verf_token'),
          'selectcond' => array('select' => '*'),
          'limit' 	 	 => array('start' => 1),
          'query' => array('query' => '(verf_code=:verf_code OR token=:token) AND exp_date >= :exp_date'),
          'wherecond'=> array('where' =>array('verf_code' => $code,'token' => sha1($token),'exp_date' => $current))
        );

        $query = DB::fetch($data);

        if( $query ){
          $requr = array(
            'table'			 => array('table' => 'users'),
            'wherecond'  => array('where' =>array('email' => $query[0]['email']))
          );

          $data = array(
            'active' => 1
          );

          $active = DB::update($data,$requr);

          if($active){

            $table ="active";
            $data = array(
              'userid' => $query[0]['id'],
              'time'   => time(),
              'active' => 1
            );

            DB::insertdata($data,$table);

            $data = array(
              'table'			 => array('table' => 'users'),
              'selectcond' => array('select' => '*'),
              'limit' 	 	 => array('start' => 1),
              'wherecond'=> array('where' =>array('email' => $query[0]['email'],'active' => 1))
            );

            $query = DB::fetch($data);

            $delete = array(
              'table'			 => array('table' => 'verf_token'),
              'wherecond'  => array('where' =>array('email' => $query[0]['email']))
            );

            $deltoken = DB::delete($delete);

            if( $deltoken ){
              $cstrong = true;
              $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

              $table ="login_tokens";
              $data = array(
                'user_id'     => $query[0]['id'],
                'token' => sha1($token),
              );

              DB::insertdata($data,$table);

              $cookie = setcookie('SNID', $token , time() + 60 * 60 * 24 * 7 , '/' , NULL , NULL , TRUE );
              $cookie = setcookie('SNID_', 1 , time() + 60 * 60 * 24 , '/' , NULL , NULL , TRUE );
            }

            if( $cookie ){
              header("Location: profile.php");
            }
          }
        } else {
          header("Location:".BASE."?msg=".urlencode(serialize("<div class='alert alert-danger'>invalid token OR verification code</div>")));
        }
      } else {
        header("Location:".BASE."");
      }
    }

    public static function login( $data ){
      validation::post($data,'user')::xss()::length(3,32)::isempty();
      validation::post($data,'Password')::xss()::isempty();

      if( validation::submit() ){
        $user  = validation::$value['user'];
        $pass   = validation::$value['Password'];

        $data = array(
      		'table'			 => array('table' => 'users'),
      		'selectcond' => array('select' => '*'),
          'limit' 	   => array('start' => 1),
          'query'      => array('query' => '(username=:username OR email=:email) AND password =:password AND active=:active'),
          'wherecond'  => array('where' =>array('username' => $user , 'email' => $user, 'password' => validation::encrypt($pass),'active' => 1))
      	);

        $query = DB::fetch($data);

        if( isset($query[0][0]) > 0 ){
          $cstrong = true;
          $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

          $table ="login_tokens";
          $data = array(
            'user_id'     => $query[0]['id'],
            'token' => sha1($token),
          );

          DB::insertdata($data,$table);

          $cookie = setcookie('SNID', $token , time() + 60 * 60 * 24 * 7 , '/' , NULL , NULL , TRUE );
          $cookie = setcookie('SNID_', 1 , time() + 60 * 60 * 24 , '/' , NULL , NULL , TRUE );

          if( $cookie ){
            header("Location: profile.php");
          }
        } else {
          return '<div class="alert alert-danger">Incorrect Email or Password</div>';
        }
      } else {
        return validation::$error;
      }
    }

    public static function changepassword( $data ){
      validation::post($data,'old-password')::xss()::isempty();
      validation::post($data,'Password')::xss()::length(8,64)::isempty()::password();
      validation::post($data,'Re-password')::xss()::isempty();

      if( validation::submit() ){
        $oldPassword  = validation::$value['old-password'];
        $password     = validation::$value['Password'];
        $rePassword   = validation::$value['Re-password'];

        if( isset($data['alldevice']) ){
          Session::init();
          Session::set('device','all');
        }

        $data = array(
      		'table'			 => array('table' => 'users'),
      		'selectcond' => array('select' => 'password'),
          'limit' 	   => array('start' => 1),
          'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
      	);

        $query = DB::fetch($data);

        if( validation::verify(validation::encrypt($oldPassword),$query[0]['password'] ) ){
          if( validation::verify( $password,$rePassword ) ){
            if( !validation::verify( validation::encrypt($password),$query[0]['password'] ) ){

              $requr = array(
            		'table'			 => array('table' => 'users'),
            		'wherecond'  => array('where' =>array('id' => Session::isloggedin()))
            	);

            	$data = array(
            		'password' => validation::encrypt($password)
            	);

              if(Session::get('device')){

                $delete = array(
                  'table'			 => array('table' => 'login_tokens'),
              		'wherecond'  => array('where' =>array('user_id' => Session::isloggedin()))
              	);

                $changepass = DB::update($data,$requr);
                $deletetoken= DB::delete($delete);
                Session::destroy();
              }else{
                $changepass = DB::update($data,$requr);
              }

              if( $changepass ){
                return '<div class="alert alert-success">Password Change Successfully</div>';
              } else {
                return '<div class="alert alert-danger">Something Went Wrong.Please Contact To Developer Team</div>';
              }
            } else {
              return '<div class="alert alert-danger">Old Password Cannot Be Save As New Password</div>';
            }
          } else {
            return '<div class="alert alert-danger">Retype Password Didnt Match</div>';
          }
        } else {
          return '<div class="alert alert-danger">Old Password Didnt Match</div>';
        }
      } else {
        return validation::$error;
      }
    }

    public static function resetreq($data){
      if(!($_POST)){
          header("Location:recover_password.php");
      } else {
        validation::post($data,'email')::xss()::length(3,64)::email()::isempty();

        if( validation::submit() ){
          $email  = validation::$value['email'];

          $data = array(
        		'table'			 => array('table' => 'users'),
        		'selectcond' => array('select' => '*'),
        		'limit' 	 	 => array('start' => 1),
        		'wherecond'=> array('where' =>array('email' => $email,'active' => 1))
        	);

          $query = DB::fetch($data);

          if($query){
            $cstrong  = true;
            $token    = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $ver_code = rand(1,1000000);
            $exp_date = time() + 1800;

            $table ="password_token";
            $data = array(
              'email'     => $email,
              'token'     => sha1($token),
              'verf_code' => sha1($ver_code),
              'user_id'   => $query[0]['id'],
              'exp_date'  => $exp_date
            );

            $insert = DB::insertdata($data,$table);

            if( $insert ){
              $message  = "Looks like you have forgotten your password.To reset your password use this code from the below</br>";
      				$message .= "<B><h3>".$ver_code."</h3></B></br>";
      				$message .= "Or you can use this link to reset your password ass well:<br>";
      				$message .= "<a href='".$_SERVER['HTTP_HOST']."/change_password.inc.php?token=".$token."'><b>".$_SERVER['HTTP_HOST']."/change_password.inc.php?token=".$token."</b></a><br>";
      				$message .= "This code will be valid only for 30 minutes</br>";
              helper::mail($email,$message);

              return true;
            } else {
              header("Location:recover_password.php?msg=".urlencode(serialize("<div class='alert alert-danger'>There was a problem</div>")));
            }
          } else {
            header("Location:recover_password.php?msg=".urlencode(serialize("<div class='alert alert-danger'>Email Doesnt Exist</div>")));
          }
        }else{
          header("Location:recover_password.php?msg=".urlencode(serialize(validation::$error)));
        }
      }
    }

    public function verfication($data){
      if( ($_POST['ver_code']) OR ($_GET['token']) ) {

        if( $_POST['ver_code'] ) {
            validation::post($_POST,'ver_code')::xss()::isempty();

            if( validation::submit() ){
              $code   = validation::$value['ver_code'];
              $token  = '';
            } else {
              header("Location:reset-req.inc.php?msg=".urlencode(serialize(validation::$error)));
            }

        } else if ($_GET['token']) {
          validation::post($_GET,'token')::xss()::isempty();

          if( validation::submit() ){
            $token   = validation::$value['token'];
            $code  = '';
          } else {
            header("Location:reset-req.inc.php?msg=".urlencode(serialize(validation::$error)));
          }
        }

        $current = time();
        $data = array(
          'table'			 => array('table' => 'password_token'),
          'selectcond' => array('select' => '*'),
          'limit' 	 	 => array('start' => 1),
          'query' => array('query' => '(verf_code=:verf_code OR token=:token) AND exp_date >= :exp_date'),
          'wherecond'=> array('where' =>array('verf_code' => sha1($code),'token' => sha1($token),'exp_date' => $current))
        );

        $query = DB::fetch($data);

        if( $query ){
          return $query[0]['user_id'];
        } else {
          header("Location:recover_password.php?msg=".urlencode(serialize("<div class='alert alert-danger'>invalid token OR verification code</div>")));
        }
      } else {
        header("Location:recover_password.php");
      }
    }

    public static function forgottenpass( $data ){
      validation::post($data,'Password')::xss()::length(8,64)::isempty()::password();
      validation::post($data,'Re-password')::xss()::isempty();

      if( validation::submit() ){
        $password     = validation::$value['Password'];
        $rePassword   = validation::$value['Re-password'];

        $user_id = $data['user_id'];

          if( validation::verify( $password,$rePassword ) ){
              $requr = array(
            		'table'			 => array('table' => 'users'),
            		'wherecond'  => array('where' =>array('id' => $user_id))
            	);

            	$data = array(
            		'password' => validation::encrypt($password)
            	);

              $changepass = DB::update($data,$requr);

              if( $changepass ){
                $delete = array(
                  'table'			 => array('table' => 'password_token'),
                  'wherecond'  => array('where' =>array('user_id' => $user_id))
                );

                $deletetoken = DB::delete($delete);

                $cstrong = true;
                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

                $table ="login_tokens";
                $data = array(
                  'user_id'     => $user_id,
                  'token' => sha1($token),
                );

                DB::insertdata($data,$table);

                $cookie = setcookie('SNID', $token , time() + 60 * 60 * 24 * 7 , '/' , NULL , NULL , TRUE );
                $cookie = setcookie('SNID_', 1 , time() + 60 * 60 * 24 , '/' , NULL , NULL , TRUE );

                header("Location: profile.php");
              } else {
                return '<div class="alert alert-danger">Something Went Wrong.Please Contact To Developer Team</div>';
              }
          } else {
            return '<div class="alert alert-danger">Retype Password Didnt Match</div>';
          }

      } else {
        return validation::$error;
      }
    }

}
 ?>
