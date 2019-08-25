<?php
 class helper{
   public static function shorten($start,$limit){

   }

   public static function mention($body,$type,$post = NULL){
     $body = explode(' ',$body);
     $newstr = '';
     foreach($body as $mention){
       if( substr($mention , 0, 1) == '@' ){

         $user = str_replace('@','',$mention);
         $data = array(
           'table'			 => array('table' => 'users'),
           'selectcond' => array('select' => '*'),
           'wherecond'  => array('where' =>array('username' => $user))
         );

         $query = DB::fetch($data);
         if($query){

           $table ="notification";
           $data = array(
             'type'     => $type,
             'sender'   => Session::isloggedin(),
             'receiver' => $query[0]['id'],
             'post'     => $post['post_id']
           );
           if($query[0]['id'] != Session::isloggedin()){
             $noti = DB::insertdata($data,$table);
           }

           $newstr .= '<a href="profile.php?username='.substr($mention,1).'">'.$mention.'</a> ';
         } else{
           $newstr .= '<span>'.$mention.'</span> ';
         }

       } else if( substr($mention , 0, 1) == '#' ){
         $newstr .= '<span style="color:#337ab7">'.$mention.'</span> ';
       } else {
         $newstr .= $mention.' ';
       }
     }
     return $newstr;
   }

   //send mail to user
 	public function mail($email,$message){
 		$mail = new PHPMailer(true);
 		try {
 				//Server settings
 				$mail->SMTPDebug = 2;                                       // Enable verbose debug output
 				$mail->Host       = 'safayat.a2hosted.com';                 // Specify main and backup SMTP servers
 				$mail->SMTPAuth   = true;                                   // SMTP password
 				$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
 				$mail->Port       = 587;                                    // TCP port to connect to
 				//Recipients
 				$mail->setFrom(Developer.'@'.$_SERVER['HTTP_HOST'] , 'Developer');
 				$mail->addAddress($email, 'Member');                        // Add a recipient
 				$subject = 'Email verification';
 				// Content
 				$mail->isHTML(true);                                        // Set email format to HTML
 				$mail->Subject = $subject;
 				$mail->Body    = $message;
 				$mail->send();
 		} catch (Exception $e) {
 				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
 		}
 	}
 	//send mail to user
 }

 ?>
