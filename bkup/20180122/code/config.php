<?php
	
	class appConfig {
		public $appSettings = [
			"appLoginPage" => "/login.php"
		];
		public $db = [
			"user" => "xxxxxxxxx",
			"pwd" => "xxxxxxxxx",
			"host" => "xxxxxxxxx",
			"name" => "atg_dashboard"
		];
	};
	
	$GLOBALS['CONFIG'] = new appConfig();
	
?>