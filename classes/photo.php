<?php 
class photo{
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