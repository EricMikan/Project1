<?php
	require_once "./code/db.php";
	
	header('Content-Type: text/plain');

	$query = mysqli_query($conn, "SELECT * FROM users");
	
	while($user_rec = mysqli_fetch_assoc($query)) {
		$kNum = 0;
		foreach ($user_rec as $key => $value) {
			if ($kNum > 0) echo ", ";
			echo $key."=".$value;
			$kNum++;
		}
		echo "\r\n";
	}
	
?>