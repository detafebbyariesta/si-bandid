<?php
include "../../../asset/inc/config.php";
$id_tanggung_jawab = $_GET['id_tanggung_jawab'];
$sql = "SELECT * FROM tb_tanggung_jawab WHERE id_tanggung_jawab= '$id_tanggung_jawab'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$tanggung_jawab = $data['tanggung_jawab'];
		$perdes = $data['perdes'];
		unlink("file/tanggungjawab/".$tanggung_jawab);
		unlink("file/perdes/".$perdes);
     }
$id_tanggung_jawab = mysqli_real_escape_string($koneksi,$_GET['id_tanggung_jawab']);
$query = mysqli_query($koneksi,"DELETE FROM tb_tanggung_jawab WHERE id_tanggung_jawab='$id_tanggung_jawab' ");
header('location:../../../index.php?page=tanggungjawab');
?>