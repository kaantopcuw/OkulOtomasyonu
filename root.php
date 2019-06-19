<?php 
	session_start();
	if (!isset($_SESSION['username']) || $_SESSION['auth'] != 0) {
		header('location:index.php');
	}


	$con = mysqli_connect("localhost", "root", "");

	// baglanti kontrolu
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	mysqli_select_db($con , "myo_ders");
	$con->set_charset("utf8");


	if (isset($_POST['isim_input']) && isset($_POST['kullanici_adi_input']) && isset($_POST['sifre_input']) ) {
		$isim_input = stripcslashes($_POST['isim_input']);
		$isim_input = mysqli_real_escape_string($con, $isim_input);

		$kullanici_adi_input = stripcslashes($_POST['kullanici_adi_input']);
		$kullanici_adi_input = mysqli_real_escape_string($con, $kullanici_adi_input);

		$sifre_input = stripcslashes($_POST['sifre_input']);
		$sifre_input = mysqli_real_escape_string($con, $sifre_input);

		$insert_sql = "INSERT INTO `users`( `name`, `username`, `password`, `auth`) VALUES ('$isim_input','$kullanici_adi_input','$sifre_input', '1')";
		$result = mysqli_query($con, $insert_sql);
		if ($result) {
			echo "Kayıt Başarılı!";
		}else{
			echo "Kaydedilemedi!";
		}
	}

	if (isset($_POST['ogretmen_select']) && isset($_POST['ders_input']) ) {
		$ogretmen_select = stripcslashes($_POST['ogretmen_select']);
		$ogretmen_select = mysqli_real_escape_string($con, $ogretmen_select);

		$ders_input = stripcslashes($_POST['ders_input']);
		$ders_input = mysqli_real_escape_string($con, $ders_input);

		$insert_sql = "INSERT INTO `lessons`(`lesson_name`, `teacher_id`) VALUES ('$ders_input','$ogretmen_select')";
		$result = mysqli_query($con, $insert_sql);
		if ($result) {
			echo "Kayıt Başarılı!";
		}else{
			echo "Kaydedilemedi!";
		}
	}


 ?>

 <html>
	<head>
	 	<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Okul Otomasyonu</title>
		<link rel="stylesheet" type="text/css" href="style/css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	</head>
	<body class="container">
	 	<div class="row">
	 		<div class="col-md-10 mx-auto">
	 			<div class="row">
	 				<div class="col-md-10 "> 
		 				<h3>Hoşgeldin Yönetici <?php echo "".$_SESSION['name']; ?></h3>
			 		</div>
			 		<div class="col-md-2">
			 			<a href="logout.php" class="btn btn-primary btn-lg active float-right" role="button" aria-pressed="true">Çıkış</a>
			 		</div>	
	 			</div>
	 			
	 		</div>
	 	</div> 
		<div class="row" style="margin-top: 25px">
			<div class="col-md-5 mx-auto bg-light">
				<div class="row ">
					<h4 class="mx-auto"> Öğretim Elemanı Ekle</h4>
				</div>
				<div class="row ">
					<form class="mx-auto" action="" method="POST">
					  <div class="form-group">
					    <label for="isim_input">Öğretim Elemanı İsmi</label>
					    <input name="isim_input" type="text" class="form-control" id="isim_input" placeholder="İsim Giriniz" required>
					  </div>
					  <div class="form-group">
					    <label for="kullanici_adi_input">Kullanıcı Adı</label>
					    <input name="kullanici_adi_input" type="text" class="form-control" id="kullanici_adi_input" placeholder="Kullanıcı Adı Giriniz" required>
					  </div>
					  <div class="form-group">
					    <label for="sifre_input">Şifre</label>
					    <input name="sifre_input" type="password" class="form-control" id="sifre_input" placeholder="Şifre Giriniz" required>
					  </div>
					  <button type="submit" class="btn btn-primary">Kaydet</button>
					</form>
				</div>
			</div>
			<div class="col-md-5 mx-auto bg-light">
				<div class="row">
					<h4 class="mx-auto"> Öğretim Elemanına Ders Ekle</h4>
				</div>
				<div class="row ">
					<form class="mx-auto" action="" method="POST">
					  <div class="form-group">
					    <label for="ogretmen_select">Öğretmen Seçiniz</label>
					    <select name="ogretmen_select" class="custom-select my-1 mr-sm-2" id="ogretmen_select">
							<?php 
								$teachers = mysqli_query($con, "SELECT * FROM `users` where `auth` != '0'");
								if($teachers){
							        while($row = mysqli_fetch_array($teachers)) {
							            print "<option value=\"".$row['id']."\">".$row['name']." - ". $row['username']."</option>";
							         }    
							    }
					       ?>
					    </select>	
					  </div>
					  <div class="form-group">
					    <label for="ders_input">Dersin Adı</label>
					    <input name="ders_input" type="text" class="form-control" id="ders_input" placeholder="Ders İsmi Giriniz" required>
					  </div>
					  <button type="submit" class="btn btn-primary">Kaydet</button>
					</form>
				</div>
			</div>

		</div>

	</body>
</html>