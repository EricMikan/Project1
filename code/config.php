<?php
	
	class appConfig {
		public $appSettings = [
			"appLoginPage" => "/login.php"
		];
		public $db = [
			"user" => "empulsemysore",
			"pwd" => "empulse_70",
			"host" => "atg-empulse.cbzzjswvipbd.us-west-2.rds.amazonaws.com",
			"name" => "atg_dashboard"
		];
	};
	
	$GLOBALS['CONFIG'] = new appConfig();
	
	//$CONFIG_appLoginPage = "/login.php";
	
	//$CONFIG_db_user = "empulsemysore";
	//$CONFIG_db_pwd = "empulse_70";
	//$CONFIG_db_host = "atg-empulse.cbzzjswvipbd.us-west-2.rds.amazonaws.com"; 
	//$CONFIG_db_name = "atg_dashboard";
	//$conn = mysqli_connect($hostname, $username, $password, $dbname); 
?>