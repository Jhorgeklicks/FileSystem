

<?php

	if (isset($_POST['folder_name']) && isset($_POST['oldfile_name']) && isset($_POST['newfile_name']) && isset($_POST['action']) ) {

		$folder_name = $_POST['folder_name'];
		$oldfile_name = $_POST['oldfile_name'];
		$newfile_name = $_POST['newfile_name'];
		$action = $_POST['action'];

		if ($action == "change_name") {
			if(!empty($newfile_name)){
				$oldname = $folder_name.'/'.$oldfile_name;
				$newname = $folder_name.'/'.$newfile_name;

				if (rename($oldname, $newname)) {

					echo  "$oldfile_name Has Been Renamed To $newfile_name";
				}else{
					echo "Error Renaming The File";
				}

			}
		}

	}

 ?>
