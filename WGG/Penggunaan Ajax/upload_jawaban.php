<?php
require $_SERVER['DOCUMENT_ROOT'].'/connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$nama_lengkap = $_POST['nama_lengkap'];
	$nrp = $_POST['nrp'];
	$jenis_kelamin = $_POST['jenis_kelamin'];
	$jurusan = $_POST['jurusan'];
	$tempat_lahir = $_POST['tempat_lahir'];
	$tanggal_lahir = $_POST['tanggal_lahir'];
	$berat_badan = $_POST['berat_badan'];
	$tinggi_badan = $_POST['tinggi_badan'];
	$alamat_asal = $_POST['alamat_asal'];
	$alamat_surabaya = $_POST['alamat_surabaya'];
	$no_hp = $_POST['no_hp'];
	$no_telp = $_POST['no_telp'];
	$nama_wali = $_POST['nama_wali'];
	$alamat_wali = $_POST['alamat_wali'];
	$no_hp_wali = $_POST['no_hp_wali'];
	$no_telp_wali = $_POST['no_telp_wali'];
	$info = $_POST['info'];

	$result = array(
		'status' => 0,
		'msg' => ''
	);

	$add = mysqli_query($con,"INSERT INTO `kesehatan_data` VALUES (NULL, '$nama_lengkap', '$nrp', '$jenis_kelamin', '$jurusan', '$tempat_lahir', '$tanggal_lahir', $berat_badan, $tinggi_badan, '$alamat_asal', '$alamat_surabaya', '$no_hp', '$no_telp', '$nama_wali', '$alamat_wali', '$no_hp_wali', '$no_telp_wali')");


	$query_id = "SELECT * FROM `kesehatan_data` WHERE nrp= '$nrp'";
	$result_id = $con->query($query_id);
	$row_id = $result_id->fetch_assoc();


	$id_mahasiswa = $row_id['id'];


	foreach ($info as $penyakit) {
		$add = mysqli_query($con,"INSERT INTO `kesehatan_penyakit`(`id`, `id_mahasiswa`, `id_pertanyaan`) VALUES (NULL,$id_mahasiswa,$penyakit)");
	}

	if(mysqli_affected_rows($con)>0){
		$result['status']=1;
		$result['msg']='Berhasil';
		//$result['msg']=$info;
	}else{
		$result['status']=0;
		$result['msg']=mysqli_error($con);
	}
	echo json_encode($result);

}else {

	header("HTTP/1.1 400 Bad Request");
	$error = array(
		'error' => 'Method not Allowed'
	);

	echo json_encode($error);
}

?>