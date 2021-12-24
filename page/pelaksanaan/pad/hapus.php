<?php
include "../../../asset/inc/config.php";
$id_realisasi_pad = $_GET['id_realisasi_pad'];
$sql = "SELECT * FROM tb_realisasi_pad WHERE id_realisasi_pad= '$id_realisasi_pad'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$realisasi_pad = $data['realisasi_pad'];
		$foto1 = $data['foto_pad_1'];
		$foto2 = $data['foto_pad_2'];
		$foto3 = $data['foto_pad_3'];
		$foto4 = $data['foto_pad_4'];
		unlink("file/pad/".$realisasi_pad);
		unlink("file/foto/foto1/".$foto1);
		unlink("file/foto/foto2/".$foto2);
		unlink("file/foto/foto3/".$foto3);
		unlink("file/foto/foto4/".$foto4);
     }
     // var_dump($realisasi_pad);
     // var_dump($foto1);
     // var_dump($foto2);
     // var_dump($foto3);
     // var_dump($foto4);

$id_realisasi_pad = mysqli_real_escape_string($koneksi,$_GET['id_realisasi_pad']);
$query = mysqli_query($koneksi,"DELETE FROM tb_realisasi_pad WHERE id_realisasi_pad='$id_realisasi_pad' ");
header('location:../../../index.php?page=p_pad');
?>