<?php

	if (isset($_POST['action']) && isset($_POST['folder_name'])) {

		$folder_name = $_POST['folder_name'];
		$action = $_POST['action'];

		if ($action == "fetch_files") {
			$file_data = scandir($folder_name);
			$output = '
					<table class="table table-striped table-hover table-bordered">
						<thead class="text-center">
							<tr>
								<th>Image</th>
								<th>File</th>
								<th>Delete</th>
							</tr>
						</thead>
			';

			foreach ($file_data as $file) {
				if($file === '.' || $file === '..'){
					continue;
				}else{
					$path = $folder_name .'/'.$file;
 					$output .= '
						<tbody>
							<tr>
								<td><img src="ajaxphp/'.$path.'" alt="image" class="img img-thumbnail" height="50" width="50"></td>
								<td contenteditable="true" data-folder_name = "'. $folder_name.'" data-file_name = "'. $file.'" class="change_file_name">'. $file .'</td>
								<td><button class="remove_file btn btn-danger btn-xs" name="remove_file" id="'. $path .'">Remove</button></td>
							</tr>
						</tbody>
					';
				}
			}
			echo $output .= '</table>';
		}else{
			echo 'Query Error. contact jhorgeklicks@gmail.com for clarification';
		}
	}

 ?>