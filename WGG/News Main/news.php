<?php
session_start();

if(!isset($_SESSION["nrp_mahasiswa"])||!isset($_SESSION["login_mahasiswa"])){
	header ('Location: /main/portal/index.php');
	exit;
}

$nrp = $_SESSION["nrp_mahasiswa"];
$time = date("H");
require $_SERVER['DOCUMENT_ROOT'].'/connect.php';

#bypass, langsung gausah nonton video

// $query_ambil_doswal = "SELECT dosen_wali FROM `mahasiswa` WHERE nrp = '$nrp'";
// $execute = $con->query($query_ambil_doswal);
// $doswal = $execute->fetch_assoc()['dosen_wali'];
//
// if($doswal != 'a'){
//   $query_check = "SELECT * FROM `news_video` WHERE nrp = '$nrp'";
//   $result_check = $con->query($query_check);
//   $row_check = $result_check->fetch_assoc();
//   $status_1 = $row_check['status_1'];
//   $status_2 = $row_check['status_2'];
//   $status_3 = $row_check['status_3'];
//
//   if(($status_1 != 1) || ($status_2 != 1) || ($status_3 != 1)){
//     header ('Location: /main/portal/news/index.php');
//     exit;
//   }
// }

$query_nrp = "SELECT jurusan.id FROM jurusan join mahasiswa ON (mahasiswa.jurusan = jurusan.nama_jurusan) WHERE mahasiswa.nrp = '$nrp'";
$result_nrp = $con->query($query_nrp);
$row_nrp = $result_nrp->fetch_assoc();
$jurusanMahasiswa = $row_nrp['id'];

$query0 = "SELECT nama_jurusan FROM `jurusan` WHERE id = '$jurusanMahasiswa'";
$result0 = $con->query($query0);
$row0 = $result0->fetch_assoc();
$namaJurusan = $row0['nama_jurusan'];
// echo ('Jurusan mahasiswa : '.$jurusanMahasiswa.'. '.$namaJurusan);

$maba2021 = 1;
$query1 = "SELECT * FROM `mahasiswa` WHERE nrp = '$nrp'";
$result1 = $con->query($query1);
$row1 = $result1->fetch_assoc();
$dosen_wali = $row1['dosen_wali'];

// echo ('Nrp : '.$nrp);
// echo (' Dosen : '.$dosen_wali);

if($nrp == "yuliaa" || $nrp == "Creative"){
	$query = "SELECT DISTINCT id, judul, pengumuman FROM news_pengumuman ORDER BY id DESC";
}else if ($dosen_wali == 'a'){
	$query = "SELECT * FROM news_pengumuman WHERE id = 667";
}else if ($dosen_wali == ''){
	$query = "SELECT * FROM news_pengumuman WHERE ((visibility = '$jurusanMahasiswa') OR (visibility = '1')) AND status <> 0 AND (visibility_doswal = '' OR visibility_doswal IS NULL) ORDER BY id DESC";
}else if ($jurusanMahasiswa == ''){
	$query = "SELECT * FROM news_pengumuman WHERE ((visibility = '1') OR (visibility_doswal LIKE '$dosen_wali%')) AND status <> 0 AND (visibility = '' OR visibility IS NULL) ORDER BY id DESC";
}else if ($dosen_wali == '' AND $jurusanMahasiswa == ''){
	$query = "SELECT * FROM news_pengumuman WHERE visibility = '1' ORDER BY id DESC";
}else{
	$query = "SELECT * FROM news_pengumuman WHERE ((visibility = '$jurusanMahasiswa') OR (visibility = '1') OR (visibility_doswal LIKE '$dosen_wali%')) AND status <> 0 ORDER BY id DESC";
}

$result = $con->query($query);

?>

<!doctype html>
<html lang="en">
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


  <title>WGG News</title>

  <head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<!-- Bootstrap CSS -->
  	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

  	<!-- Link font navbar -->
  	<link rel="stylesheet" type="text/css" href="https://wgg.petra.ac.id/assets/css/fonts.css">
  	<link rel="preconnect" href="https://fonts.gstatic.com">
  	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">


  	<style type="text/css">


  		.bg {
  			background-size: cover;
  			background-repeat: no-repeat;
  			width : 100vw;
  			height : 100vh;
  			z-index: -99999;
  			position : fixed;
  		}

  		.box{
  			align-items: center;
  			width:100%;
  			padding:20px;
  			border-radius:10px;
  		}

  		.container_me{
  			margin: auto;
  			width: 70%;
  		}

  		table {
  			margin-top:15px;
  			font-family: Arial, Helvetica, sans-serif;
  			border-collapse: collapse;
  			width: 100%;
  		}

  		table td, table th {
  			border: 1px solid #ddd;
  			padding: 8px;
  		}

  		table tr:nth-child(even){background-color: #f2f2f2;}

  		table tr:hover {background-color: #ddd;}

  		table th {
  			padding-top: 12px;
  			padding-bottom: 12px;
  			text-align: left;
  			background-color: #4CAF50;
  			color: white;
  		}

  		#background{
  			width: 70%;
  			margin-left:15%;
  			margin-top:15px;
  		}

  		.accordion {
  			background-color: white;
  			color: black;
  			cursor: pointer;
  			padding: 18px;
  			width: 100%;
  			border: none;
  			text-align: left;
  			outline: none;
  			transition: 0.4s;
  			font-size: 18px;
  		}

  		.active, .accordion:hover {
  			background-color: #eee;
  		}

  		.panel {
  			padding: 0 18px;
  			background-color: white;
  			max-height: 0;
  			overflow-x: scroll;
  			transition: max-height 0.2s ease-out;
  		}
  		.panel::-webkit-scrollbar {
  			display: none;
  		}
  		.panel p {
  			padding: 15px 0 0 0;
  			font-size: 15px;
  		}
  		.footer-logo img{
  			width: 12%!important;
  			margin-left:0!important;
  			margin-top:0!important;
  			padding-bottom: 58px;
  		}
  		.footer-logo{
  			height : 10px;

  		}

  		@media only screen and (min-width: 768px) {
  			.footer-logo img{
  				width: 100px!important;
  			}

  		}
  		@media screen and (max-width: 630px) {
  			.accordion {
  				background-color: white;
  				color: black;
  				cursor: pointer;
  				padding: 18px;
  				width: 100%;
  				border: none;
  				text-align: left;
  				outline: none;
  				transition: 0.4s;
  				font-size: 14px;

  			}

  			.container_me{
  				margin: auto;
  				width: 90%;
  			}
  		}
  	</style>

  </head>
  <body>
  	<div class = "bg">
  	</div>

  	<!-- NAVBAR -->
  	<?php include "../navbar/navbar.php"; ?>

  	<h1 class='pt-5 title' style=text-align:center;>WGG NEWS</h1>

  	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  	<!-- Optional JavaScript; choose one of the two! -->

  	<!-- Option 1: Bootstrap Bundle with Popper -->
  	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script> -->

  	<!-- Option 2: Separate Popper and Bootstrap JS -->
     <!--
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
 -->
 <div class = "container_me">

 	<div class = "box">

 		<?php
 		$i=1;
 		while($row = $result->fetch_assoc()){
 			$judul=($row['judul']);
 			$pengumuman=($row['pengumuman']);
 			$output =
 			'
 			<button class="accordion" style="border-radius:5px;">'.$judul.'</button>
 			<div class="panel" style="border-radius:5px;">
 			'.$pengumuman.'
 			</div>
 			<br>

 			';
 			echo $output;
 			$i++;
 		};
 		?>

 		<script>

 			var acc = document.getElementsByClassName("accordion");
 			var i;

 			for (i = 0; i < acc.length; i++) {
 				acc[i].addEventListener("click", function() {
 					this.classList.toggle("active");
 					var panel = this.nextElementSibling;
 					if (panel.style.maxHeight) {
 						panel.style.maxHeight = null;
 					} else {
 						panel.style.maxHeight = panel.scrollHeight + "px";
 					}
 				});
 			}

 		</script>
 	</div>
 </div>

 <div class="container" >
 	<div class ="container footer-logo text-center">
 		<?php
  if($time>6 && $time<=15){//pagi
  	echo ('<img id="background" src="/assets/images/main/logo wgg color font hitam.png"/>');
  }else if($time>15 && $time<=18){//sore
  	echo ('<img id="background" src="/assets/images/main/logo wgg color font putih.png"/>');
  }else if($time>=5 && $time<=6){//subuh
  	echo ('<img id="background" src="/assets/images/main/logo wgg color font putih.png"/>');
  }else{//malam
  	echo ('<img id="background" src="/assets/images/main/logo wgg color font putih.png"/>');
  }

  ?>
</div>

</div>
  <!-- <h1 style=text-align:center;>WGG :")</h1>
  -->
</body>
</html>
