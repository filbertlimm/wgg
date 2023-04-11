<?php

include $_SERVER['DOCUMENT_ROOT']."/connect.php";
session_start();
$nrp = $_GET['nrp'];

$query_check = "SELECT * FROM `news_video` WHERE nrp = '$nrp'";
$result_check = $con->query($query_check);
$row_check = $result_check->fetch_assoc();
$status_1 = $row_check['status_1'];
$status_2 = $row_check['status_2'];
$status_3 = $row_check['status_3'];

?>

<?php if($status_1 == 1 && $status_2 == 1 && $status_3 == 1): ?>
  <a href="/main/portal/news/news.php"><button type="button" class="btn btn-primary" name="button">Lanjutkan ke News</button></a>
<?php else: ?>
  <button type="button" class="btn btn-primary" name="button" disabled>Lanjutkan ke News</button>
<?php endif; ?>
