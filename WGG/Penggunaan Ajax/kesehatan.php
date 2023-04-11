<?php
session_start();
if(!isset($_SESSION["nrp_mahasiswa"])||!isset($_SESSION["login_mahasiswa"])){
	header ('Location: /main/portal/index.php');
	exit;
}

require $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$final_nrp = $_SESSION["nrp_mahasiswa"];

$sudah_isi = mysqli_query($con,"SELECT * FROM kesehatan_data WHERE nrp = '$final_nrp'");

if(mysqli_num_rows($sudah_isi) === 1){
	echo "<script>alert('Form hanya dapat diisi sekali. Anda sudah isi')</script>";
	header ('Location: /main/portal/index.php');
	exit;
}

$time = date("H");


function getDataFromDb($query)
{
	global $con;
	$result = mysqli_query($con, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

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

  <!doctype html>
  <html lang="en">
  <head>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<!-- Bootstrap CSS -->
  	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  	<title>Form Kesehatan</title>
  </head>
  <body>

  	<!-- Optional JavaScript; choose one of the two! -->

  	<!-- Option 1: Bootstrap Bundle with Popper -->
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

  	<!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
-->
<style type="text/css">
	.box{
		background-color:#f9f9f9;
		align-items: center;
		width:50%;
		margin:auto;
		padding:20px;
		border-radius:10px;

	}
	.small{
		font-size: 35px;
		padding-top: 40px;
	}

	.bg {
		background-size: cover;
		background-repeat: no-repeat;
		width : 100vw;
		height : 100%;
		z-index: -99999;
		position : fixed;
	}

	label {
		display: block;
		font: 1rem 'Fira Sans', sans-serif;
	}

	input,
	label {
		margin: .4rem 0;
	}

</style>

<div class = "bg">
</div>

<div class = "pt-5">

	<form method = "POST" enctype="multipart/form-data">

		<div class = "box container">
			<h1 style = "text-align: center;">DATA DIRI</h1>


			<div class = "row">
				<div class="mb-3 col-md-6 col-sm-12">
					<label class="form-label" for="form1">Nama Lengkap : </label>
					<input name = "nama_lengkap" type="text" class="form-control" required/>
				</div>

				<div class="mb-3 col-md-6 col-sm-12">
					<label class="form-label" for="form1">NRP : </label>
					<input name="nrp" type="text" class="form-control" required=""/>
				</div>

			</div>

			<select class="form-select" aria-label="Default select example" name="jenis_kelamin">
				<option value ="none">Pilih Jenis Kelamin</option>
				<option value="Laki-laki">Laki-laki</option>
				<option value="Perempuan">Perempuan</option>
			</select>
			<br>

			<select class="form-select mb-3" aria-label="Default select example" name = "jurusan">
				<option value="none">Pilih Jurusan</option>

				<?php 
				$sql = mysqli_query($con, "SELECT * FROM jurusan");

				$i = 1;
				while ($row = $sql->fetch_assoc()){


					echo "<option value=\"".$row['nama_jurusan']."\">". $i,'. ',$row['nama_jurusan']."</option>";
					$i++;
            // close while loop 
				}
				?>

			</select>


			<div class="mb-3 col-md-6 col-sm-12">
				<label class="form-label" for="form1">Tempat Lahir : </label>
				<input name = "tempat_lahir" type="text" class="form-control" required/>
			</div>

			<div class="mb-3 col-md-6 col-sm-12">
				<label class = "form-label" for="start">Tanggal Lahir : </label>
				<input class="form-control" type="date" id="start" name="tanggal_lahir" value="2003-01-01" min="1990-01-01" max="2021-12-31">
			</div>

			<div class = "row ">
				<div class="mb-3 col-md-6 col-sm-12">
					<label class="form-label" for="form1">Berat Badan (Kg) : </label>
					<input name = "berat_badan" type="number" class="form-control" required=""/>
				</div>

				<div class="mb-3 col-md-6 col-sm-12">
					<label class="form-label" for="form1">Tinggi Badan (Cm) : </label>
					<input name="tinggi_badan" type="number" class="form-control" required=""/>
				</div>
			</div>

			<div class="mb-3 col-md-6 col-sm-12" style="width : 100%">
				<label class="form-label" for="form1">Alamat Asal : </label>
				<input name="alamat_asal" type="text" class="form-control" required=""/>
			</div>

			<div class="mb-3 col-md-6 col-sm-12" style="width : 100%">
				<label class="form-label" for="form1">Alamat Surabaya : </label>
				<input name="alamat_surabaya" type="text" class="form-control" required=""/>
			</div>

			<div class = "row">
				<div class="mb-3 col-md-6 col-sm-12">
					<label class="form-label" for="form1">No HP : </label>
					<input name = "no_hp" type="text" class="form-control" required=""/>
				</div>

				<div class="mb-3 col-md-6 col-sm-12">
					<label class="form-label" for="form1">No Telp : </label>
					<input name="no_telp" type="text" class="form-control" required=""/>
				</div>
			</div>
		</div>
		<br><br>
		<div class = "box container">
			<h1 style = "text-align: center;">DATA ORANG TUA/WALI </h1>

			<div class = "row">
				<div class="mb-3 col-md-6 col-sm-12">
					<label class="form-label" for="form1">Nama Lengkap : </label>
					<input name = "nama_wali" type="text" class="form-control" required=""/>
				</div>

				<div class="mb-3 col-md-6 col-sm-12" style="width : 100%">
					<label class="form-label" for="form1">Alamat : </label>
					<input name="alamat_wali" type="text" class="form-control" required=""/>
				</div>

				<div class = "row">
					<div class="mb-3 col-md-6 col-sm-12">
						<label class="form-label" for="form1">No HP : </label>
						<input name = "no_hp_wali" type="text" class="form-control" required=""/>
					</div>

					<div class="mb-3 col-md-6 col-sm-12">
						<label class="form-label" for="form1">No Telp : </label>
						<input name="no_telp_wali" type="text" class="form-control" required=""/>
					</div>
				</div>
			</div>
		</div>
		<br><br>
		<div class = "box container">
			<h1 style = "text-align: center;">KLIK KOTAK JIKA MEMILIKI RIWAYAT ATAU SEDANG SAKIT</h1>

			<ul class="list-group" style="padding:30px;">
				<?php
				$sql = "SELECT * FROM `kesehatan_daftar_pertanyaan`"; 
				$result = getDataFromDb($sql);
					// var_dump($result);
				?>
				<?php foreach ($result as $key) : ?>
					<li class="list-group-item">
						<input class="form-check-input me-1 penyakit" type="checkbox" value="<?= $key['id']; ?>" name = "<?= $key['id']; ?>" aria-label="...">

						<?= $key['pertanyaan'];?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>


	</div>
	<!-- Button Submit -->
	<div style=padding:15px;text-align:center;>
		<button id = "submit" name = "submit" value = "submit" type="submit" class="btn btn-primary mb-3" >SUBMIT</button>
	</div>
</form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
	$( document ).ready(function() {
		Array.prototype.remove = function() {
			var what, a = arguments, L = a.length, ax;
			while (L && this.length) {
				what = a[--L];
				while ((ax = this.indexOf(what)) !== -1) {
					this.splice(ax, 1);
				}
			}
			return this;
		};

		var info = [];
		$('.penyakit').change(function(e){
			if($(this).prop('checked')==true){
				console.log($(this).val());
				info.push($(this).val());
			}else if ($(this).prop('checked')==false){
				info.remove($(this).val());
			}
		});

		$('button[id ="submit"]').click(function(e){
			e.preventDefault();
			//MAHASISWA
			const nama_lengkap = $('input[name="nama_lengkap"]').val();
			const nrp = $('input[name="nrp"]').val();
			const jurusan =  $('select[name="jurusan"]').val();
			const jenis_kelamin = $('select[name="jenis_kelamin"]').val();
			const tempat_lahir = $('input[name="tempat_lahir"]').val();
			const tanggal_lahir = $('input[name="tanggal_lahir"]').val();
			const berat_badan = $('input[name="berat_badan"]').val();
			const tinggi_badan = $('input[name="tinggi_badan"]').val();
			const alamat_asal = $('input[name="alamat_asal"]').val();
			const alamat_surabaya = $('input[name="alamat_surabaya"]').val();
			const no_hp = $('input[name="no_hp"]').val();
			const no_telp = $('input[name="no_telp"]').val();

			//WALI
			const nama_wali = $('input[name="nama_wali"]').val();
			const alamat_wali = $('input[name="alamat_wali"]').val();
			const no_hp_wali = $('input[name="no_hp_wali"]').val();
			const no_telp_wali = $('input[name="no_telp_wali"]').val();

			// alert (nama_lengkap+' '+nrp+' '+jurusan+' '+jenis_kelamin+' '+tempat_lahir+' '+tanggal_lahir+' '+berat_badan+' '+tinggi_badan+' '+alamat_asal+' '+alamat_surabaya+' '+no_hp+' '+no_telp+' '+nama_wali+' '+alamat_wali+' '+no_hp_wali+' '+no_telp_wali);
			
			//CHECKBOX
			// const no1 = $('input[name="1"]').val();
			// const no2 = $('input[name="2"]').val();
			// const no3 = $('input[name="3"]').val();

			console.log(info);
			$.ajax({
				url: 'upload_jawaban.php',
				method: 'POST',
				dataType: 'json',
				data: { 
					nama_lengkap : nama_lengkap,
					nrp : nrp,
					jenis_kelamin : jenis_kelamin,
					jurusan : jurusan,
					tempat_lahir : tempat_lahir,
					tanggal_lahir : tanggal_lahir,
					berat_badan : berat_badan,
					tinggi_badan : tinggi_badan,
					alamat_asal : alamat_asal,
					alamat_surabaya : alamat_surabaya,
					no_hp : no_hp,
					no_telp : no_telp,
					nama_wali : nama_wali,
					alamat_wali : alamat_wali,
					no_hp_wali : no_hp_wali,
					no_telp_wali : no_telp_wali,
					info : info
				},
				success: function(data) {

					alert(data.msg);

				},
				error: function(request, status, error) {
					console.log('error');
					$("#messages").html("<div class='alert alert-danger' role='alert'>" + request.responseText + "</div>");
				}
			});

		});

	});
</script>
</body>

</html>