<?php
include "../../../asset/inc/config.php";
$id_lppd = $_GET['id_lppd'];
$sql = "SELECT * FROM tb_lppd WHERE id_lppd= '$id_lppd'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$lppd = $data['lppd'];
		unlink("file/lppd/".$lppd);
     }
$id_lppd = mysqli_real_escape_string($koneksi,$_GET['id_lppd']);
$query = mysqli_query($koneksi,"DELETE FROM tb_lppd WHERE id_lppd='$id_lppd' ");
header('location:../../../index.php?page=lppd');
?>