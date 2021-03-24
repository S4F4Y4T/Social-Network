<?php 
class posts{
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
                $body = nl2br($body);
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
                $body = nl2br($body);
                $body = helper::mention($body,$type=2);
                $table ="post";
    
                $data = array(
                  'user_id' => Session::isloggedin(),
                  'body'    => $body
                );
    
                $posted = DB::insertdata($data,$table);
                if($posted){
                    
                    header("Location:profile.php");
                }
    
              } else {
                return validation::$error;
              }
            }
    
          }
        }
      }
}