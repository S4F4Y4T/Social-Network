<?php
class validation{
	public static $error = array();
	public static $value = array();
	public static $currentvalue;

	public function __construct(){}

	public static function post($data,$key){
		self::$value[$key] = $data[$key];
		self::$currentvalue = $key;
		return __CLASS__;
	}

	public static function xss(){
		self::$value[self::$currentvalue] = trim(self::$value[self::$currentvalue]);
		self::$value[self::$currentvalue] = htmlspecialchars(self::$value[self::$currentvalue]);
		self::$value[self::$currentvalue] = stripcslashes(self::$value[self::$currentvalue]);
		return __CLASS__;
	}

	public static function isempty(){
		if(empty(self::$value[self::$currentvalue])){
			self::$error = "<div class='alert alert-danger'>Field Must Not Be Empty</div>";
		}
		return __CLASS__;
	}

	public static function length($min,$max){
	if(strlen(self::$value[self::$currentvalue]) < $min || strlen(self::$value[self::$currentvalue]) > $max){
			self::$error = "<div class='alert alert-danger'>".self::$currentvalue.":Length should be between ".$min."-".$max."</div>";
		}
		return __CLASS__;
	}

	public static function email(){
		if(!filter_var(self::$value[self::$currentvalue], FILTER_VALIDATE_EMAIL)){
			self::$error = "<div class='alert alert-danger'>Invalid Email</div>";
		}
		return __CLASS__;
	}

	public static function username(){
		self::$value[self::$currentvalue] = preg_replace('/\s+/','',self::$value[self::$currentvalue]);

		return __CLASS__;
	}

	public static function password(){
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', self::$value[self::$currentvalue])){
			self::$error = '<div class="alert alert-danger">Password is too weak</div>';
		}
	}

	public static function emptyfiles($name){
			if(empty($name)){
				self::$error = '<div class="alert alert-danger">Must attach a image</div>';
			}
			return __CLASS__;
	}

	public static function size($size){
		if($size < 1024 || $size > 1048576){
			self::$error = '<div class="alert alert-danger">Size must be between 1kb-1mb</div>';
		}
		return __CLASS__;
	}

	public static function extention($ext){
		$permit = array('jpg','jpeg','png','gif');
		if(in_array($ext,$permit) == false){
			self::$error = "You Can Upload Only ".implode(',',$permit)." File";
			self::$error = '<div class="alert alert-danger">You can upload only '.implode(',',$permit).' file</div>';
		}
		return __CLASS__;
	}

	public static function verify($value1,$value2){
		if($value1 == $value2){
			return true;
		}else{
			return false;
		}
	}

	public static function encrypt($pass){
		$password = $pass;

		$password = str_replace(" ","0",$password);
		$password = str_replace("0","0",$password);

		$password = str_replace("1","1a9",$password);
		$password = str_replace("2","2b8",$password);
		$password = str_replace("3","3c7",$password);
		$password = str_replace("4","4d6",$password);
		$password = str_replace("5","5e5",$password);
		$password = str_replace("6","6w4",$password);
		$password = str_replace("7","7x3",$password);
		$password = str_replace("8","8y2",$password);
		$password = str_replace("9","9z1",$password);

		$password = str_replace("a","a9z",$password);
		$password = str_replace("b","b8y",$password);
		$password = str_replace("c","c7x",$password);
		$password = str_replace("d","d6w",$password);
		$password = str_replace("e","e5v",$password);
		$password = str_replace("f","f4u",$password);
		$password = str_replace("g","g3t",$password);
		$password = str_replace("h","h2s",$password);
		$password = str_replace("i","i1r",$password);
		$password = str_replace("j","j0q",$password);
		$password = str_replace("k","k1p",$password);
		$password = str_replace("l","l2o",$password);
		$password = str_replace("m","m3n",$password);
		$password = str_replace("n","n4m",$password);
		$password = str_replace("o","o5l",$password);
		$password = str_replace("p","p6k",$password);
		$password = str_replace("q","q7j",$password);
		$password = str_replace("r","r8i",$password);
		$password = str_replace("s","s9h",$password);
		$password = str_replace("t","t0g",$password);
		$password = str_replace("u","u9f",$password);
		$password = str_replace("v","v8e",$password);
		$password = str_replace("w","w7d",$password);
		$password = str_replace("x","x6c",$password);
		$password = str_replace("y","y5b",$password);
		$password = str_replace("z","z4a",$password);

		$password = str_replace("@","123",$password);
		$password = str_replace("(","149",$password);
		$password = str_replace(")","198",$password);
		$password = str_replace("<","186",$password);
		$password = str_replace(">","512",$password);
		$password = str_replace("{","622",$password);
		$password = str_replace("}","792",$password);
		$password = str_replace("[","881",$password);
		$password = str_replace("]","989",$password);
		$password = str_replace("$","105",$password);
		$password = str_replace("&","925",$password);

		$password = sha1($password);

		return $password;
	}

	public static function submit(){
		if(empty(self::$error)){
			return true;
		}else{
			return false;
		}
	}
}
?>
