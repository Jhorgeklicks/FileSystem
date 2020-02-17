
<?php

	if (isset($_POST['folder_name']) && isset($_POST['action'])) {
		$folder = $_POST['folder_name'];
		$action = $_POST['action'];

		if ($action === "delete") {
			$files = scandir($folder);

			foreach ($files as $file) {
				 if ($file === "." || $file === "..") {
				 	continue;
				 }else{
				 	unlink($folder.'/'.$file);

				 }
			}
			if (rmdir($folder)){

				echo "$folder Deleted";
			}else{
				echo "Cannot Delete $folder, Try Again Later";
			}

		}

	}

 ?>