<?php

	function format_folder_size($size){
		if ($size >= 1073741824) {
			$size = number_format($size / 1073741824, 2) . ' GB';
		}
		elseif ($size >= 1048576) {
			$size = number_format($size / 1048576, 2). ' MB';
		}
		elseif ($size >= 1024) {
			$size = number_format($size / 1024, 2). ' KB';
		}
		elseif($size > 1){
			$size = $size. 'byte';
		}
		else{
			$size =  '0 byte';
		}
		return $size;
	}

	function get_folder_size($folder_name){
		$total_size = 0;
		$file_data  = scandir($folder_name);

		foreach ($file_data as $file) {
			if ($file == '.' || $file == '..') {
				continue;
			}else{
				$path = $folder_name .'/'.$file;
				$fileSize = filesize($path);
				$total_size += $fileSize;

				return format_folder_size($total_size);
			}
		}

	}


	if(isset($_POST['action'])){

		if (isset($_POST['action']) == 'fetch') {
			// echo "fetched";
			// returns list of folder names in array format
			$folder = array_filter(glob('*'),'is_dir');
			$output = '
					<table class="table table-striped table-hover table-bordered">

						<tr>
							<th>Folder Name</th>
							<th>Total File</th>
							<th>Size</th>
							<th>Update</th>
							<th>delete</th>
							<th>Upload File</th>
							<th>New Uploaded File</th>
						</tr>
			';

			if (count($folder) > 0) {

				foreach($folder as $name){
					$output .='
						<tr>
							<td>'. $name .'</td>
							<td>'. (count(scandir($name)) - 2 ) .'</td>
							<td>'. get_folder_size($name) .'</td>
							<td><button name="update" data-name="'.$name.'" type="button" class="update btn btn-warning btn-xs">Update</button></td>
							<td><button name="delete" data-name="'.$name.'" type="button" class="delete btn btn-danger btn-xs">Delete</button></td>
							<td><button name="upload" data-name="'.$name.'" type="button" class="upload btn btn-info btn-xs">Upload</button></td>
							<td><button name="view_files" data-name="'.$name.'" type="button" class="view_files btn btn-default btn-xs">View_files</button></td>
						</tr>
					';
				}

			}else{
				$output .= '
					<tr>
						<td class="col-6">No records found</td>
					</tr>
				';
			}

			$output .='</table>';

			echo $output;

		}
	}

 ?>