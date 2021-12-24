<?php
include "../../../asset/inc/config.php";
$id_ba_kas = $_GET['id_ba_kas'];
$sql = "SELECT * FROM tb_ba_kas WHERE id_ba_kas= '$id_ba_kas'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$ba_kas = $data['ba_kas'];
		unlink("file/ba_kas/".$ba_kas);
     }
$id_ba_kas = mysqli_real_escape_string($koneksi,$_GET['id_ba_kas']);
$query = mysqli_query($koneksi,"DELETE FROM tb_ba_kas WHERE id_ba_kas='$id_ba_kas' ");
header('location:../../../index.php?page=ba_kas');
?>