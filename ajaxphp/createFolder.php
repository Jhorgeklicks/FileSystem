<?php

if (isset($_POST['action']) && isset($_POST['folder_name']) && isset($_POST['oldname'] )) {

				$action = $_POST['action'];
				$folder_name = $_POST['folder_name'];
				$old_name = $_POST['oldname'];
				// echo "$action and $folder_name";

				if($action == "create"){
					if(!file_exists($folder_name)){

						mkdir($folder_name, 0777, true);

						echo "$folder_name Folder Created";


					}else{
						echo "$folder_name Folder Already Exist";
					}
				}

				// if the update btn is sent
				if ($action == "change") {
					if (!file_exists($folder_name)) {
						rename($old_name, $folder_name);
						echo "Folder name Changed";
					}else{
						echo "$folder_name already created";
					}
				}

		}
 ?>