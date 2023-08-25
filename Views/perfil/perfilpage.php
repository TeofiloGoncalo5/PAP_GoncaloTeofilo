<?php

include '../partials/header.php';
include '../partials/left.php';
include '../partials/footer.php';

include_once '../../db.php';

$sql = mysqli_query($conn, "SELECT * FROM users WHERE id = {$_SESSION['theId']}");
if (mysqli_num_rows($sql) > 0) {
	$row = mysqli_fetch_assoc($sql);
}

$data = array(
	'username' => $row['username'],
	'email' => $row['email'],
	'img' => $row['img']
);

$folderPath = '../../assets/img'; // Specify the path to the "img" folder
?>


<html>

<head>
	<title>Profile Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="deperfil.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="card">
		<h2>
			<div class="img-container">
				<img class="img-form" name="img" id="img" src="../../assets/img/<?php echo $row['img']; ?>" onerror="this.src = 'https://i.pinimg.com/originals/83/bc/8b/83bc8b88cf6bc4b4e04d153a418cde62.jpg'" alt="">
				<label for="imgFile" class="filePut"> <i class="fa-sharp fa-solid fa-camera"></i> </label>
				<input type="file" id="imgFile" style="display: none" accept="image/*">
				<input type="hidden" id="imgFile_base64">
			</div>
		</h2>
		<form class="profile">
			<div class="form-group">
				<label for="nome">Nome:</label>
				<input type="text" id="username" name="username" value="<?php echo $row['username']; ?>">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" value="<?php echo $row['email']; ?>">
			</div>
			<div class="button-group">
				<input type="button" value="Salvar" id="form-submit">
			</div>
		</form>
	</div>
</body>

</html>

<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../assets/plugins/jszip/jszip.min.js"></script>
<script src="../../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>




<script src=https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js></script>
<script src=https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js></script>
<script src=https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js></script>


<!-- Page specific script -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>



<script>
	$(document).ready(() => {
		imgFile = null;
		$('#imgFile').on('change', function() {
			var file = this.files[0];
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function() {
				$(".fa-sharp").removeClass("fa-camera");
				$(".fa-sharp").addClass("fa-check");
				var base64 = reader.result;
				$(".img-form").attr("src", base64);
				console.log(file);
				imgFile = {
					"dataURL": base64,
					"type": file.type
				};
			};
		});
	});
	$('#form-submit').on('click', function() {
		var email = $('#email').val();
		var username = $('#username').val();
		console.log(email);
		console.log(username);
		console.log(imgFile);
		$.ajax({
			url: "<?= $global_configs['SERVER_URL'] ?> /api/save_perfil.php",
			method: 'POST',
			data: {
				"email": email,
				"username": username,
				"img": imgFile,
			}
		}).done(function(res) {
			res = JSON.parse(res);
			toastr[res.status](res.message);
			console.log(res);
			setTimeout(() => {
				window.location.reload();
			}, 2000);

		}).fail(function(err) {
			res = JSON.parse(err);
			toastr[res.status](res.message);
		});
	});
</script>