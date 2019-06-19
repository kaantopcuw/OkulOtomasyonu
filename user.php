<?php 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	

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

	if (isset($_POST['table_id'])) {//tablo ismi doluysa bunu ekranda göstermek gerek
		//mysql injection koruması
		$table_id = stripcslashes($_POST['table_id']);
		$table_id = mysqli_real_escape_string($con, $table_id);
	}

	if (isset($_POST['student_add'])) {
		$student_add = stripcslashes($_POST['student_add']);
		$student_add = mysqli_real_escape_string($con, $student_add);
		$add_student_with_id = "INSERT INTO `student_taking_lasson`(`students_id`, `lessons_id`, `vize_note`, `final_note`, `letter_note`) VALUES ('$student_add','$table_id',NULL,NULL,NULL)";
		$resut = mysqli_query($con, $add_student_with_id);

	}


	function getTable($table_name) {//verilen isimeki tablodan tum dataları çekip bir diziye yerleştirir.

		$con = mysqli_connect("localhost", "root", "");
		mysqli_select_db($con, "myo_ders");
	    $sql = "SELECT * FROM `$table_name`";
	    $result = mysqli_query($con, $sql);
	    $data = [];
	    if($result){
	        while($row = mysqli_fetch_array($result)) {

	            $data[] = $row; 
	         }    
	    }
	    mysqli_close($con);
	    return $data;
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
		<script>
			function isInt(value) {
			  return !isNaN(value) && 
			         parseInt(Number(value)) == value && 
			         !isNaN(parseInt(value, 10));
			}

			function saveNoteData(id,students_id,lessons_id,sutun){
				if (id != null) {
					let data = document.getElementById(id).value;
					var httpr = new XMLHttpRequest();
					httpr.open("POST","saveNote.php",true);
					httpr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					httpr.send("students_id="+students_id+"&lessons_id="+lessons_id+"&sutun="+sutun+"&data="+data);

					let vizeData = document.getElementById(students_id+"vize_note").value;
					let finalData = document.getElementById(students_id+"final_note").value;
					let ortalamaLabel = document.getElementById(students_id+"_ortalama");

					if(isInt(vizeData) && isInt(finalData)){
						let ortalama = (parseInt(vizeData) + parseInt(finalData)) / 2;
						ortalamaLabel.innerHTML = ortalama;
					}

					

				}
				
			}

		</script>

	</head>
	<body class="container">
	 	<div class="row">
	 		<div class="col-md-10 mx-auto">
	 			<div class="row">
	 				<div class="col-md-10 "> 
		 				<h3>Hoşgeldin Öğretmen <?php echo "".$_SESSION['name']; ?></h3>
			 		</div>
			 		<div class="col-md-2">
			 			<a href="logout.php" class="btn btn-primary btn-lg active float-right" role="button" aria-pressed="true">Çıkış</a>
			 		</div>	
	 			</div>
	 			
	 		</div>
	 		
	 	</div> 	
	 	<div class="row">
	 		<div class="col-md-10 mx-auto">
	 			<form class="form-inline" action="" method="POST">
					<label class="my-1 mr-2" for="table_id_select">Dersi Seçiniz: </label>
					<select name="table_id" class="custom-select my-1 mr-sm-2" id="table_id_select">
						<?php 
							$user_id = $_SESSION['id'];
							$lessons = mysqli_query($con, "SELECT * FROM `lessons` where `teacher_id` = '$user_id'");
							
							if($lessons){
						        while($row = mysqli_fetch_array($lessons)) {
						            print "<option value=\"".$row['id']."\">".$row['lesson_name']."</option>";
						         }    
						    }
				       ?>
				    </select>	
				  	<button type="submit" class="btn btn-primary my-1">Getir</button>
				</form>
	 		</div>
	 	</div>
	 	<div class="row">
	 		<div class="col-md-10 mx-auto"> 
				<?php 
					if (isset($table_id)) {
						$tablo_sql = "SELECT students.id,students.number,students.name,lessons_id, vize_note,final_note,letter_note FROM `student_taking_lasson` INNER JOIN `students` ON student_taking_lasson.students_id = students.id WHERE lessons_id = '$table_id'";

						$tabloSatirlar = mysqli_query($con, $tablo_sql);
						if($tabloSatirlar){
							$sira = 1;
								?>
								<div class="table-responsive-xl" id="yazdir">
									<table class="table table-striped">
									  <thead>
									    <tr>
									      <th style="width: 5%" scope="col">#</th>
									      <th style="width: 15%" scope="col">Numara</th>
									      <th style="width: 25%" scope="col">İsim</th>
									      <th style="width: 13%" scope="col">Vize Notu</th>
									      <th style="width: 13%" scope="col">Final Notu</th>
									      <th style="width: 13%; text-align: center;" scope="col">Ortalama</th>
									      <th style="width: 13%" scope="col">Harf Notu</th>
									    </tr>
									  </thead>
									  <tbody>
									
					            <?php

					        while($row = mysqli_fetch_array($tabloSatirlar)) {
					            ?>
									<tr>
								      <th scope="row"><?php echo $sira; $sira++; ?></th>
								      <td><?php echo $row['number']; ?></td>
								      <td><?php echo $row['name']; ?></td>
								      <td>
								      	<input type="text" name="vize_note" class="form-control" id="<?php echo $row['id']; ?>vize_note" value="<?php echo $row['vize_note']; ?>" onkeyup="saveNoteData('<?php echo $row['id']; ?>vize_note','<?php echo $row['id']; ?>','<?php echo $table_id; ?>','vize_note')" >
								      </td>
								      <td>
								      	<input type="text" name="final_note" class="form-control" id="<?php echo $row['id']; ?>final_note" value="<?php echo $row['final_note']; ?>" onkeyup="saveNoteData('<?php echo $row['id']; ?>final_note','<?php echo $row['id']; ?>','<?php echo $table_id; ?>','final_note')">
								      </td>
								      <td style="vertical-align:middle;text-align: center;" id="<?php echo $row['id'];?>_ortalama"> <?php 
								      		$ortalama = ($row['vize_note'] + $row['final_note'] ) / 2;
								      		echo $ortalama;
								       ?></td>
								      <td>
								      	<input type="text" name="letter_note" class="form-control" id="<?php echo $row['id']; ?>letter_note" value="<?php echo $row['letter_note']; ?>" onkeyup="saveNoteData('<?php echo $row['id']; ?>letter_note','<?php echo $row['id']; ?>','<?php echo $table_id; ?>','letter_note')">
								      </td>
								    </tr>
									
					            <?php

					         } 
					         	?>
									  </tbody>
									</table>
								</div>
					            <?php

					    }
					}
				 ?>
	 		</div>
	 	</div> 
	 	<?php 
	 		if (isset($table_id)) {
	 	 ?>
	 	<div class="row">
	 		<div class="col-md-10 mx-auto">
	 			<div class="row">
	 				<div class="col-md-10">
	 					<form class="form-inline" action="" method="POST">
							<div style="display: none;">
								<input name="table_id" type="text"  value="<?php echo $table_id; ?>">
							</div>
			 				<label class="my-1 mr-2" for="student_add_select">Öğrenci Ekle:</label>
			 				<select name="student_add" class="custom-select my-1 mr-sm-2" id="student_add_select">
			 					<?php
			 					 	$notEqualStudentSql = "SELECT * FROM `students` WHERE `id` NOT IN (SELECT students_id FROM `student_taking_lasson` WHERE student_taking_lasson.lessons_id = '$table_id' )";
									$notEqualStudent = mysqli_query($con, $notEqualStudentSql);
									if($notEqualStudent){
								        while($row = mysqli_fetch_array($notEqualStudent)) {
								            echo "<option value=\"".$row['id']."\">".$row['number']." ".$row['name']."</option>";
								         }    
								    }
			 						
						       ?>
			 				</select>
			 				<button type="submit" class="btn btn-primary my-1">Ekle</button>
						</form>
	 				</div>
	 				<div class="col-md-2">
			 			<a href="javascript:window.print()" class="btn btn-primary btn-lg active float-right" role="button" aria-pressed="true">Yazdır</a>
			 		</div>	
	 			</div>
	 		</div>
	 	</div>
	 	<?php 
	 		} // if blogunun kapanışı
	 	?>
		<div class="row">
			
		</div>
	</body>
</html>

