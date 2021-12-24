<?php
include "../../../asset/inc/config.php";
$id_ippd = $_GET['id_ippd'];
$sql = "SELECT * FROM tb_ippd WHERE id_ippd= '$id_ippd'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$ippd = $data['ippd'];
		unlink("file/ippd/".$ippd);
     }
$id_ippd = mysqli_real_escape_string($koneksi,$_GET['id_ippd']);
$query = mysqli_query($koneksi,"DELETE FROM tb_ippd WHERE id_ippd='$id_ippd' ");
header('location:../../../index.php?page=ippd');
?>