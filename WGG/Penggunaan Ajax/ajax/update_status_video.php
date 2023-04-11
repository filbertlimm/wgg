<?php

include $_SERVER['DOCUMENT_ROOT']."/connect.php";
session_start();
header("Content-Type: application/json");
$nrp = $_SESSION['nrp_mahasiswa'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = array(
      'status' => 0,
      'msg' => ''
    );

    $video_nu = $_POST['video_no'];

    //cek keberadaan email atau username
    $check = mysqli_query($con, "SELECT * FROM `news_video` WHERE nrp='$nrp'");

    if (mysqli_num_rows($check) === 1) {
      if ($video_nu == 1) {
        $query_nrp = "UPDATE `news_video` SET status_1 = 1 WHERE nrp = '$nrp'";
        $result_nrp = $con->query($query_nrp);
        $result['status'] = 1;
        $result['msg'] = "success";
      } else if ($video_nu == 2) {
        $query_nrp = "UPDATE `news_video` SET status_2 = 1 WHERE nrp = '$nrp'";
        $result_nrp = $con->query($query_nrp);
        $result['status'] = 1;
        $result['msg'] = "success";
      } else if ($video_nu == 3) {
        $query_nrp = "UPDATE `news_video` SET status_3 = 1 WHERE nrp = '$nrp'";
        $result_nrp = $con->query($query_nrp);
        $result['status'] = 1;
        $result['msg'] = "success";
      }
    } else {
      if ($video_nu == 1) {
        $query_nrp = "INSERT INTO `news_video` VALUES (NULL,'$nrp',1,0,0)";
        $result_nrp = $con->query($query_nrp);
        $result['status'] = 1;
        $result['msg'] = "success";
      } else if ($video_nu == 2) {
        $query_nrp = "INSERT INTO `news_video` VALUES (NULL,'$nrp',0,1,0)";
        $result_nrp = $con->query($query_nrp);
        $result['status'] = 1;
        $result['msg'] = "success";
      } else if ($video_nu == 3) {
        $query_nrp = "INSERT INTO `news_video` VALUES (NULL,'$nrp',0,0,1)";
        $result_nrp = $con->query($query_nrp);
        $result['status'] = 1;
        $result['msg'] = "success";
      }
    }




    echo json_encode($result);
} else {
    header("HTTP/1.1 400 Bad Request");
    $error = array(
        'error' => 'Method not Allowed'
    );

    echo json_encode($error);
}
