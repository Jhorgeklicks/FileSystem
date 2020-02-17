<?php


if (isset($_FILES['upload_file'])) {

	if ($_FILES['upload_file']['name'] != '') {

		$filename = $_FILES['upload_file']['name'];
		$fileTempname = $_FILES['upload_file']['tmp_name'];

		$ext = explode(".", $filename);
		$extension = $ext[1];
		$allowedExt = ['jpg','png','jpeg','gif'];

		if(in_array($extension , $allowedExt)){
			$new_file_name = rand() . '.' . $extension;
			$path = $_POST['hidden_folder_name'] . '/' . $new_file_name;

			if(move_uploaded_file($fileTempname, $path)){
				echo "$filename Uploaded Successfully";
			}else{
				echo "Error Uploading $filename";
			}
		}else{
			echo "File with .$ext[1] extension is not valid";
		}

	}else{
		echo "please select an Image";
	}
}


 ?>