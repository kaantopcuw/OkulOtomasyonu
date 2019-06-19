<?php 
	session_start();
	if (isset($_SESSION['username']) ) {
		if ($_SESSION['auth'] == 0) {
			header('location:root.php');
		}elseif ($_SESSION['auth'] == 1) {
			header('location:user.php');
		}
		
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Okul Otomasyonu</title>
	<link rel="stylesheet" type="text/css" href="style/css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body class="container">
	<div class="row" style="height: 100%">
		<div class="col-sm-12 my-auto" >
			<div class="w-50 mx-auto"><h2>Okul Otomasyonu</h2></div>
			<form class="form-horizontal card card-block w-50 mx-auto bg-light" action="login.php" method="POST">

			  	<div class="form-group">
			    	<label for="username" class="col-sm-4 control-label">Kullanıcı Adı</label>
			    	<div class="col-sm-10">
			      		<input type="text" name="username" class="form-control" id="username" placeholder="Kullanıcı Adı" required>
			    	</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="password" class="col-sm-4 control-label">Şifre</label>
			    	<div class="col-sm-10">
			      		<input type="password" name="password" class="form-control" id="password" placeholder="Şifre" required>
			    	</div>
			  	</div>

			  	<div class="form-group">
			    	<div class="col-sm-offset-2 col-sm-10">
			      		<button type="submit" class="btn btn-primary">Giriş Yap</button>
			    	</div>
			  	</div>

			</form>
		</div>
	</div>
	
</body>
</html>