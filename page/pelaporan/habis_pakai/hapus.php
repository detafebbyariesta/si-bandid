<?php
include "../../../asset/inc/config.php";
$id_habis_pakai = $_GET['id_habis_pakai'];
$sql = "SELECT * FROM tb_habis_pakai WHERE id_habis_pakai= '$id_habis_pakai'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$habis_pakai = $data['habis_pakai'];
		unlink("file/habis_pakai/".$habis_pakai);
     }
$id_habis_pakai = mysqli_real_escape_string($koneksi,$_GET['id_habis_pakai']);
$query = mysqli_query($koneksi,"DELETE FROM tb_habis_pakai WHERE id_habis_pakai='$id_habis_pakai' ");
header('location:../../../index.php?page=habis_pakai');
?>