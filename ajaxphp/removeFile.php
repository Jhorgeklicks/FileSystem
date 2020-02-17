<?php

	if (isset($_POST['action']) && isset($_POST['path'])) {

		$path = $_POST['path'];
		$action = $_POST['action'];

		if (!file_exists($path)) {
			echo 'path does not exist';
		}else{
			unlink($path);
			echo "$path Removed Successfully";
		}



	}
 ?>