<?php
session_start();
$time = date("H");

require $_SERVER['DOCUMENT_ROOT'].'/connect.php';
?>
<!doctype html>
<html lang="en">
<head>
	<title>
		Upload News
	</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

	  	<!-- Link font navbar -->
  	<link rel="stylesheet" type="text/css" href="https://wgg.petra.ac.id/assets/css/fonts.css">
  	<link rel="preconnect" href="https://fonts.gstatic.com">
  	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
	<script src = 'ckeditor/ckeditor.js'>


	</script>
</head>
<body>

	<!-- Optional JavaScript; choose one of the two! -->

	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

	<!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
-->
<div class = "bg">
</div>

<h1 class='pt-5 title' style=text-align:center;>INPUT NEWS</h1>
<?php
  if($time>6 && $time<=15){//pagi
  	echo ('<link rel="stylesheet" href="css/morning.css">');
  }else if($time>15 && $time<=18){//sore
  	echo ('<link rel="stylesheet" href="css/noon.css">');
  }else if($time>=5 && $time<=6){//subuh
  	echo ('<link rel="stylesheet" href="css/noon.css">');
  }else{//malam
  	echo ('<link rel="stylesheet" href="css/night.css">');
  }

  ?>
  <style type="text/css">
  	.bg {
  		background-size: cover;
  		background-repeat: no-repeat;
  		width : 100vw;
  		height : 100%;
  		z-index: -99999;
  		position : fixed;
  	}
  	.box{
  		background-color:#e3e3e3;
  		align-items: center;
  		width:80%;
  		margin:auto;
  		padding:20px;
  		border-radius:10px;


  	}
  </style>

  <div style=margin:auto;>
  	<!-- Text Fields -->
  	<form method = "post" enctype="multipart/form-data">
  		<div class = "box container">

  			<div class = "row">

  				<div class="mb-3 col-md-6 col-sm-12">
  					<label class="form-label" for="form1">Judul : </label>
  					<input name = "sub" type="text" class="form-control" required=""/>
  				</div>

  				<div class="mb-3 col-md-6 col-sm-12">
  					<label class="form-label" for="form1">Tanggal : </label>
  					<input name="judul" type="text" class="form-control" value="UPDATE - " required=""/>
  				</div>

  			</div>

  			<div class="form-outline" style="padding-bottom: 10px;">
  				<label class="form-label" for="form2" >Isi :</label>
  				<textarea name = "pengumuman" type="text" id="form2" class="form-control" style=height:100px; required="" id="pengumuman">

  				</textarea>
  			</div>

  			<!-- Drop Down -->
  			<!-- <div class="row"> -->
  				<select class="form-select mb-3" aria-label="Default select example" name = "visibility">
  					<option value=NULL>Visibility</option>

  					<?php
  					$sql = mysqli_query($con, "SELECT * FROM jurusan");

  					$i = 1;
  					while ($row = $sql->fetch_assoc()){


  						echo "<option value=\"".$i."\">". $row['id'],'. ',$row['nama_jurusan']."</option>";
  						$i++;
            // close while loop
  					}
  					?>

  				</select>

  				<!-- </div> -->


  				<!-- Jenis Attachment -->

  				<input type="file" name="file[]" multiple/>

  			</div>

  			<div style=padding:15px;text-align:center;>
  				<!-- Button Submit -->
  				<button name = "submit" value = "Submit" type="submit" class="btn btn-primary mb-3" >SUBMIT</button>
  				<br>
  				<!-- Button Clear -->
  				<button name = "clear" value = "Clear" type="submit" class="btn btn-danger ">CLEAR</button>
  			</div>
  		</form>

  	</div>
  	<script>
  		CKEDITOR.replace('pengumuman');
  	</script>
  </div>
</body>
</html>

<?php

if(isset($_POST['submit']))
{

	$abc = '';
	if(!empty($_FILES['file']['name'][0])){
		$correct = 1;
		$files = $_FILES['file'];

		$uploaded = array();
		$failed = array();

		$allowed = array('jpg','png','mp4','pdf');

		foreach ($files['name'] as $position => $file_name) {
			$file_tmp = $files['tmp_name'][$position];
			$file_size = $files['size'][$position];
			$file_error = $files['error'][$position];

			$file_ext = explode('.', $file_name);
			$file_ext = strtolower(end($file_ext));

			if(in_array($file_ext, $allowed)){

				if($file_error===0){

					    if($file_size <= 10000000){//10MB max

					    	$file_name_new = uniqid('',true).'.'.$file_ext;
					    	//$file_name_new = $file_tmp.'.'.$file_ext;
					    	$file_destination = $_SERVER['DOCUMENT_ROOT'].'/main/portal/news/uploads/'.$file_name_new;
					    	if($file_ext=="png"||$file_ext=="jpg"){

					    		$temp = '<img class="img" src= "/main/portal/news/uploads/'.$file_name_new.'"/>';
					    		$abc = "$abc <br> $temp <p>&nbsp;</p>";
					    	}else if($file_ext=="mp4"){
					    		$temp = '<video controls width="100%">

					    		<source src="/main/portal/news/uploads/'.$file_name_new.'"
					    		type="video/webm">

					    		<source src="/main/portal/news/uploads/'.$file_name_new.'"
					    		type="video/mp4">

					    		</video>';
					    		$abc = "$abc <br> $temp <p>&nbsp;</p>";

					    	}else if($file_ext=="pdf"){
					    		$temp = '<a href="/main/portal/news/uploads/'.$file_name_new.'"><img style = "width:33px; height:40px; margin-right:10px; margin-bottom:10px" src= "/main/portal/news/uploads/pdf_icon.png"/>'.$file_name.'</a>.';
					    		$abc = "$abc <br> $temp <p>&nbsp;</p>";
					    	}

					    	if(move_uploaded_file($file_tmp, $file_destination)){
					    		$uploaded[$position] = $file_destination;
					    		echo '<script> alert("TEST") </script>';
					    	}else{
					    		$failed[$position] = "[{$file_name}] failed to upload";
					    		$correct = 0;
					    	}
					    }else{
					    	$failed[$position] = "[{$file_name}] is too large";
					    	$correct = 0;
					    }

					}else{
						$failed[$position]="[{$file_name}] errored with code {$file_error}";
						$correct = 0;
					}

				}else{
					$failed[$position]="[{$file_name}] file extension '{$file_ext}' is not allowed";
					$correct = 0;
				}
				// print_r($file_ext);
				echo 'file tmp : ',$file_tmp, '<br>';
				echo $position,'<br>';
				echo 'file destination : ',$file_destination,'<br>';

			}
			if(!empty($uploaded)){
				print_r($uploaded);

			}
			if(!empty($failed)){
				print_r($failed);

			}
			if($correct == 1){
				echo "SUBMITTED MEDIA!";
				$sub = $_POST['sub'];
				$judul = $_POST['judul'];
				$judul2 = "[$judul] $sub";
				$pengumuman = $_POST['pengumuman'];
				$pengumuman2 = "$pengumuman $abc";
				$visibility = $_POST['visibility'];
				// if($visibility = "NULL"){
				// 	$visibility = NULL;
				// }
				$status = 1;

				$add = mysqli_query($con,"INSERT INTO `news_pengumuman`(`id`, `judul`, `pengumuman`, `visibility`, `visibility_doswal`, `visibility_kelompok`, `status`) VALUES (NULL,'$judul2','$pengumuman2','$visibility','',NULL,$status)");
			}

		}else{
			echo "SUBMITTED NORMAL!";
			$sub = $_POST['sub'];
			$judul = $_POST['judul'];
			$judul2 = "[$judul] $sub";
			$pengumuman = $_POST['pengumuman'];
			$pengumuman2 = "$pengumuman $abc";
			$visibility = $_POST['visibility'];
			// if($visibility = "NULL"){
			// 		$visibility = NULL;
			// 	}
			$status = 1;

			$add = mysqli_query($con,"INSERT INTO `news_pengumuman`(`id`, `judul`, `pengumuman`, `visibility`, `visibility_doswal`, `visibility_kelompok`, `status`) VALUES (NULL,'$judul2','$pengumuman2','$visibility','',NULL,$status)");
		}

	}



	if(isset($_POST['clear'])){
		echo "CLEARED!";
		$_POST['sub'] = '';
		$_POST['judul'] = '';
		$_POST['pengumuman'] = '';
		$_POST['visibility'] = '';
		$_POST['attachment'] = '';
	}
	?>
