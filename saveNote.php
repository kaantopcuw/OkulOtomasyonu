<?php 

	session_start();
	if (!isset($_SESSION['username']) || $_SESSION['auth'] != 1) {
		header('location:index.php');
	}
	$con = mysqli_connect("localhost", "root", "");

	// baglanti kontrolu
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	mysqli_select_db($con , "myo_ders");
	$con->set_charset("utf8");

	$students_id = stripcslashes($_POST['students_id']);
	$lessons_id = stripcslashes($_POST['lessons_id']);
	$sutun = stripcslashes($_POST['sutun']);
	$data = stripcslashes($_POST['data']);

	
	$sql = "UPDATE `student_taking_lasson` SET `$sutun` = '$data' WHERE `students_id` = '$students_id' AND `lessons_id` = '$lessons_id' ";
	$result = mysqli_query($con, $sql);

 ?>