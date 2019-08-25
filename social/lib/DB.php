<?php
	include_once "./config/config.php";
	include_once './config/phpmailer/PHPMailerAutoload.php';
class DB{

	public static function connect(){
    try{
      $dsn = "mysql:host=".host.";dbname=".dbname;
      $con = new PDO($dsn,username,password);
      $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      return $con;
    }catch(PDOException $e){
      die("Database connection lost").$e->getMessage();
    }
	}


	/* $data = array(
		'table'			 => array('table' => 'login'),
		'pkey'			 => array('pkey' => 'id'),
		'selectcond' => array('select' => '*'),
		'orderby'	   => array('order' => 'DESC'),
		'limit' 	 	 => array('start' => 1),
		'search'   	 => 'search',
		'validation' => 'validation',
		//'wherecond'=> array('where' =>array('catid' => 156))
	); */
  public static function fetch($data = array()){

		$sql  = 'SELECT ';

		if(array_key_exists('selectcond',$data)){
			foreach($data['selectcond'] as $key => $value){
				$sql .= $value;
			}
		}

		$sql .= ' FROM ';

		if(array_key_exists('table',$data)){
			foreach($data['table'] as $key => $value){
				$sql .= $value.' ';
			}
		}

        if(array_key_exists('search',$data)){
            if(array_key_exists('wherecond',$data)){
    			foreach($data['wherecond'] as $key => $val){
    					$sql .= ' WHERE ';
    					$i = 0;
    					foreach($val as $keys => $value){
    					$add = ($i > 0)?' OR ':'';
    					$sql .= "$add"."$keys LIKE '%$value%'";
    					$i++;
    					}
    			}
    		}
			}else if(array_key_exists('query',$data)){
				if(array_key_exists('wherecond',$data)){
    			foreach($data['wherecond'] as $key => $val){
    					$sql .= ' WHERE ';
							foreach($data['query'] as $key => $value){
								$sql .= $value;
							}
    			}
    		}
			}else{
    		if(array_key_exists('wherecond',$data)){
    			foreach($data['wherecond'] as $key => $val){
    					$sql .= ' WHERE ';
    					$i = 0;
    					foreach($val as $keys => $value){
    					$add = ($i > 0)?' AND ':'';
    					$sql .= "$add"."$keys=:$keys";
    					$i++;
    					}
    			}
    		}
      }

		if(array_key_exists('orderby',$data)){
			$sql .= " ORDER BY ";

			if(array_key_exists('pkey',$data)){
				foreach($data['pkey'] as $key => $value){
					$sql .= $value.' ';
				}
			}

			foreach($data['orderby'] as $key => $val){
				$sql .= $val;
			}
		}

		if(array_key_exists('limit',$data)){
			$sql .= ' LIMIT ';
			$i = 0;
			foreach($data['limit'] as $key => $value){
				$add = ($i > 0)?',':'';
				$sql .= $add.$value;
				$i++;
			}
		}

		$sttmt = $sql;
		$query = self::connect()->prepare($sttmt);

        if(array_key_exists('search',$data)){
            NULL;
        }else{
    		if(array_key_exists('wherecond',$data)){
    			foreach($data['wherecond'] as $key => $val){
    				if($key == 'where'){
    					foreach($val as $keys => $value){
    						$query->bindValue(":$keys","$value");
    					}
    				}
    			}
    		}
        }

		$query->execute();
		$result = $query->fetchAll();
		return $result;

	}


	/* $data = array(
		'TableMain'		 => array('TableMain' => 'product'),
		'Tablea'			   => array('Tablea'    => 'category'),
		//'Tableb'			 => array('Tableb'    => 'brand'),
		'Tablec'			 => array('Tablec'    => 'subcat'),

		'Mainconda'			   => array('Mainconda' => 'category'),
		//'Maincondb'			 => array('Maincondb' => 'brand'),
		'Maincondc'			 => array('Maincondc' => 'subcategory'),

		'Conda'			   => array('Conda' => 'catid'),
		//'Condb'			 => array('Condb' => 'brandid'),
		'Condc'			 => array('Condc' => 'subid'),

		'selectcond' => array('select' => '*'),
		'orderby'	  => array('order'  => 'DESC'),
		'pkey'       => array('pkey'   => 'id'),
		//'limit' 	  => array('start'  => 0,'limit' => 2),
		//'wherecond'=> array('where'  =>array('subid' => '1'))
	); */

	//join multiple Database

	public static function fetchbyquery($sql,$data=array()){
			$query = self::connect()->prepare($sql);

			if(array_key_exists('wherecond',$data)){
				foreach($data['wherecond'] as $key => $val){
					if($key == 'where'){
						foreach($val as $keys => $value){
							$query->bindValue(":$keys","$value");
						}
					}
				}
			}

			$query->execute();
			$result = $query->fetchAll();
			return $result;
}

	//join multiple Database

	/* $data = array(
		'name'     => $name
	);
	$table ="table";
	DB::insertdata($data,$table); */

	//Insert Data Into Database
	public static function insertdata($data,$table){
		$keys   = implode(",",array_keys($data));
		$values = ":".implode(", :",array_keys($data));

		$sql   = "INSERT INTO $table($keys) VALUES($values)";
		$query = self::connect()->prepare($sql);

		foreach($data as $key => $val){
			$query->bindValue(":$key",$val);
		}
		return $result = $query->execute();
	}
	//Insert Data Into Database


	/*
	$requr = array(
		'table'			 => array('table' => 'login'),
		//'wherecond'=> array('where' =>array('catid' => 156))
	);

	$data = array(
		'data' => $data
	);
	update($data,$requr);
	*/

	//Update Data Into Database
	public static function update($data,$requr){
			$upkey = NULL;

			foreach($data as $key => $val){
				$upkey .= "$key=:$key,";
			}
			$upkey = rtrim($upkey,",");


			$sql = "UPDATE ";

			if(array_key_exists('table',$requr)){
				foreach($requr['table'] as $key => $value){
					$sql .= $value.' ';
				}
			}

			$sql .= "SET $upkey";

			if(array_key_exists('wherecond',$requr)){
				foreach($requr['wherecond'] as $key => $val){
						$sql .= ' WHERE ';
						$i = 0;
						foreach($val as $keys => $value){
						$add = ($i > 0)?' AND ':'';
						$sql .= "$add"."$keys=:$keys";
						$i++;
						}
				}
			}

			$stmt = self::connect()->prepare($sql);

			foreach($data as $key => $val){
				$stmt->bindValue(":$key",$val);
			}

			if(array_key_exists('wherecond',$requr)){
				foreach($requr['wherecond'] as $key => $val){
					foreach($val as $keys => $value){
						$stmt->bindValue(":$keys","$value");
					}
				}
			}

			return $result = $stmt->execute();
		}
	//Update Data Into Database


	/* $data = array(
    'table'			 => array('table' => 'product'),
		//'choice'		 => array('single' => 'catid'),
		//'choice'		 => array('id' => '1','id' =>'2'),
		'wherecond'  => array('where' =>array('id' => base64_decode($id)))
	); */

	//Delete Data From Database
	public static function delete($data){
		$sql = "DELETE FROM ";

		if(array_key_exists('table',$data)){
			foreach($data['table'] as $key => $value){
				$sql .= $value.' ';
			}
		}

		if(array_key_exists('wherecond',$data)){
			foreach($data['wherecond'] as $key => $val){
					$sql .= ' WHERE ';
					$i = 0;
					foreach($val as $keys => $value){
					$add = ($i > 0)?' AND ':'';
					$sql .= "$add"."$keys=:$keys";
					$i++;
					}
			}
		}

		$stmt = self::connect()->prepare($sql);

		if(array_key_exists('wherecond',$data)){
			foreach($data['wherecond'] as $key => $val){
				if($key == 'where'){
					foreach($val as $keys => $value){
						$stmt->bindValue(":$keys","$value");
					}
				}
			}
		}

		return $result = $stmt->execute();
	}
	//Delete Data From Database

}
?>
