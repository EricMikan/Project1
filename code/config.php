<?php
	
	class appConfig {
		public $appSettings = [
			"appLoginPage" => "/login.php"
		];
		public $db = [
			"user" => "xxxxx",
			"pwd" => "xxxxx",
			"host" => "xxxxxxxxx",
			"name" => "atg_dashboard"
		];
	};
	
	$GLOBALS['CONFIG'] = new appConfig();
	
	 
?>