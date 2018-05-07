<?php
	require_once "./code/config.php";


	$loadclasses=function ($classname) {
		$file =  $_SERVER['DOCUMENT_ROOT']."/classes/".$classname.".php";
		if (file_exists($file))
		{require($file);}
	};

	spl_autoload_register($loadclasses);
	
	session_start();
	
	$GLOBALS['SPECS'] = new appSpecs();
	$GLOBALS['SECURITY'] = new appSecurity();
?>