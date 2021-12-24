<?php
include "../../../asset/inc/config.php";
$id_rpd = $_GET['id_rpd'];
$sql = "SELECT * FROM tb_rpd WHERE id_rpd= '$id_rpd'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$rpd = $data['rpd'];
		unlink("file/rpd/".$rpd);
     }
$id_rpd = mysqli_real_escape_string($koneksi,$_GET['id_rpd']);
$query = mysqli_query($koneksi,"DELETE FROM tb_rpd WHERE id_rpd='$id_rpd' ");
header('location:../../../index.php?page=rpd');
?>