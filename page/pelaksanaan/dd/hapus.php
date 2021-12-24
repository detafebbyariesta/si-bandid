<?php
include "../../../asset/inc/config.php";
$id_realisasi_dd = $_GET['id_realisasi_dd'];
$sql = "SELECT * FROM tb_realisasi_dd WHERE id_realisasi_dd= '$id_realisasi_dd'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$realisasi_dd = $data['realisasi_dd'];
		$foto1 = $data['foto_dd_1'];
		$foto2 = $data['foto_dd_2'];
		$foto3 = $data['foto_dd_3'];
		$foto4 = $data['foto_dd_4'];
		unlink("file/p_dd/".$realisasi_dd);
		unlink("file/foto/foto1/".$foto1);
		unlink("file/foto/foto2/".$foto2);
		unlink("file/foto/foto3/".$foto3);
		unlink("file/foto/foto4/".$foto4);
     }

$id_realisasi_dd = mysqli_real_escape_string($koneksi,$_GET['id_realisasi_dd']);
$query = mysqli_query($koneksi,"DELETE FROM tb_realisasi_dd WHERE id_realisasi_dd='$id_realisasi_dd' ");
header('location:../../../index.php?page=p_dd');
?>