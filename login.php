<?php 
	ini_set('display_errors', 1);
	error_reporting(-1);

	session_start();
	if (isset($_SESSION['username']) ) {
		if ($_SESSION['auth'] == 0) {
			header('location:root.php');
		}elseif ($_SESSION['auth'] == 1) {
			header('location:user.php');
		}
		
	}


	if (isset($_POST["username"]) && isset($_POST["password"])) {
		$con = mysqli_connect("localhost", "root", "");

		// baglanti kontrolu
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		mysqli_select_db($con , "myo_ders");
		$con->set_charset("utf8");


		$username = $_POST["username"];
		$password = $_POST["password"];

		//mysql injection korumasi
		$username = stripcslashes($username);
		$password = stripcslashes($password);
		$username = mysqli_real_escape_string($con, $username);
		$password = mysqli_real_escape_string($con, $password);
		
		$result = mysqli_query($con , "select * from users where username = '$username' and password = '$password' ");

		$row = mysqli_fetch_array($result);

		if ($row['username'] == $username && $row['password'] == $password) {
			//Kullanıcı bilgilerini sessiona kaydet
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $username;
			$_SESSION['name'] = $row['name'];
			$_SESSION['auth'] = $row['auth'];

			if ($row['auth'] == 0) {//yetkisine uygun sayfaya yonlendir
				header('location:root.php');
			}else if ($row['auth'] == 1) {
				header('location:user.php');
			}

		}else{
			header('location:index.php');
		}
	}else{
		header('location:index.php');
	}
	



 ?>