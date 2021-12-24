<?php
include "../../../asset/inc/config.php";
$id_realisasi_add = $_GET['id_realisasi_add'];
$sql = "SELECT * FROM tb_realisasi_add WHERE id_realisasi_add= '$id_realisasi_add'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$realisasi_add = $data['realisasi_add'];
		$foto1 = $data['foto_add_1'];
		$foto2 = $data['foto_add_2'];
		$foto3 = $data['foto_add_3'];
		$foto4 = $data['foto_add_4'];
		unlink("file/add/".$realisasi_add);
		unlink("file/foto/foto1/".$foto1);
		unlink("file/foto/foto2/".$foto2);
		unlink("file/foto/foto3/".$foto3);
		unlink("file/foto/foto4/".$foto4);
     }

$id_realisasi_add = mysqli_real_escape_string($koneksi,$_GET['id_realisasi_add']);
$query = mysqli_query($koneksi,"DELETE FROM tb_realisasi_add WHERE id_realisasi_add='$id_realisasi_add' ");
header('location:../../../index.php?page=p_add');
?>