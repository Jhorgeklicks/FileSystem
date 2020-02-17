<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>File System Tutorials</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
</head>
<body>

	<div class="container">
		<h2 align="center">List folder(s) from directory- <span class="text-capitalize text-success">PHP File System</span>
		</h2>
	<!-- end of the header text -->

	<div align="right">
		<button type="button" name="create_folder" id="create_folder" class="btn btn-success">Create</button>
	</div><br>
	<!-- end of the div right alignment -->

	<div id="folder-table" class="table-responsive">

	</div>
	<!-- folder table ends here -->

</div>
<script src="../jquery.js"></script>
<script src="../bootstrap.js"></script>
<script>
	$(document).ready(function(){
		fetch_folder_list();
		function fetch_folder_list(){
			let action = "fetch";
			$.ajax({
				type: "POST",
				url : "ajaxphp/action.php",
				data : {action : action},
				success : (response) => {
					$("#folder-table").html(response);
				}

			});
		}
		//  function ends here

//  when the CREATE BTN IS CLICKED
		$("body").on("click","#create_folder",function(){
			$("#action").val('create');
			$("#folder_name").val('');
			$("#folder_btn").val('Create');
			$("#oldname").val('');
			$("#change_title").text('Create Folder');
			$(".desc_title").text("Enter Folder Name");
			$("#change_title").text("Create Folder");

			// $("#folderModal").modal('show');
			$("#folderModal").modal('show');
		});

		// WHEN THE CREATE BTN IS CLICKED ON THE MODAL
		$("body").on("click", "#folder_btn", function(){
			let folder_name = $("#folder_name").val();
			let action 		= $("#action").val();
			let oldname     = $("#oldname").val();

			if(folder_name != '') {
				$.ajax({

					type 	: "POST",
					url  	: "ajaxphp/createFolder.php",
					data 	: {folder_name:folder_name, oldname:oldname, action:action},
					success : (data) =>{
						$("#folderModal").modal('hide');
						fetch_folder_list();
						alert(data);

					}

				});

			}else{
				alert("please Enter A Folder Name");
			}
		});

		//  WHEN THE UPDATE BTN IS CLICKED
		$("body").on("click", ".update", function(){

			let folder_name = $(this).data("name");
			$("#oldname").val(folder_name);
			$("#folder_name").val(folder_name);
			$("#action").val("change");

			$("#folder_btn").val("Update");
			$(".desc_title").text("Change Folder Name");
			$("#change_title").text("Rename Folder");

			$("#folderModal").modal('show');

		});

		$("body").on("click", ".upload", function(){
			let folder_name = $(this).data("name");
			$("#hidden_folder_name").val(folder_name);
			$("#UploadModal").modal('show');
		});

		// when the upload btn is clicked
		$("body").on("click", "#upload_btn", function(){

			$.ajax({

				type 		: "POST",
				url 		: "ajaxphp/upload.php",
				data 		: new FormData($("#upload_form")[0]),
				contentType : false,
				cache 		: false,
				processData : false,
				success 	: (response) => {
					fetch_folder_list();

					$("#UploadModal").modal('hide');
					alert(response);
				}

			})
		});

		//  when the View File button is clicked
		$("body").on("click", ".view_files", function(){
			let folder_name = $(this).data("name");
			let action  = "fetch_files";

			$.ajax({
				type 	: "POST",
				url 	: "ajaxphp/fetchFiles.php",
				data 	: {action:action,folder_name:folder_name},
				success : (response) =>{
					$("#fileList").html(response);
					$("#fileListModal").modal('show');
				}
			})

		});

		// if the remove btn is clicked on the View File modal
	$("body").on("click", ".remove_file", function(){
			let path = $(this).attr("id");
			let action  = "remove_file";

			if (confirm("Are You Sure You Want to delete ?")) {

				$.ajax({
				type 	: "POST",
				url 	: "ajaxphp/removeFile.php",
				data 	: {path:path, action:action},
				success : (response) => {
					alert(response);
					$("#fileListModal").modal('hide');
					fetch_folder_list();
				}

			 })
			}else{
				return false;
			}
	});

	// if the delete btn is clicked on the table
	$("body").on("click", ".delete", function(){
			let folder_name = $(this).data("name");
			let action = "delete";

			if(confirm("Do You Want To Delete The Entire Folder ??")){

				$.ajax({
					type 	: "POST",
					url 	: "ajaxphp/DeleteFolder.php",
					data 	: {folder_name:folder_name, action:action},
					success : (response) => {
						alert(response);
						fetch_folder_list();
					}
				});
			}else{
				return false;
			}
	});
		// change the image name in the folder
	$("body").on("blur", ".change_file_name", function(){

			let folder_name = $(this).data("folder_name");
			let oldfile_name = $(this).data("file_name");
			let newfile_name = $(this).text();

			let action = "change_name";

				$.ajax({
					type 	: "POST",
					url 	: "ajaxphp/changeFileName.php",
					data 	: {folder_name:folder_name, oldfile_name:oldfile_name,newfile_name:newfile_name,action:action},
					success : (response) => {
						alert(response);
						fetch_folder_list();
					}
				});

	});


	});
</script>
</body>
</html>

<div id="folderModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="change_title"> Folder</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="desc_title">Enter Folder Name</p>
				<input type="text" name="folder_name" id="folder_name" class="form-control"><br/>
				<input type="hidden" name="action" id="action">
				<input type="hidden" name="oldname" id="oldname">

				<input type="button" name="folder-btn" id="folder_btn" class="btn btn-info" value="Create">
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Upload Folder Modal -->
<div id="UploadModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="change_title"> Upload Folder</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form method="POST" id="upload_form" enctype="multipart/form-data">
					<p class="desc_title">Select a File to Upload</p>
					<input type="file" name="upload_file">
					<br><br/>
					<input type="hidden" name="hidden_folder_name" id="hidden_folder_name">

					<input type="button"  name="upload_btn" id="upload_btn" class="btn btn-info" value="Upload">
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- View File List Modal -->
<div id="fileListModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="change_title"> File Lists</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="fileList">

      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
      </div>
    </div>
  </div>
</div>