<?php

class appRender {
	public $type = "default";
	public $debug = "";
	
	public $renderQueue = [];
	
	function __construct($initType = "default") {
		$this->type = $initType;
	}
	
	function renderHeader($startBody = true) {
		include "./include/header.php";
		if ($startBody) $this->startBody();
	}
	
	function startBody() {
		echo "\r\n</head>\r\n<body>";
	}
	
	function renderFooter() {
		include "./include/footer.php";
	}
}

?>