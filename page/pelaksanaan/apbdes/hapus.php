<?php
include "../../../asset/inc/config.php";
$id_realisasi_apbdes = $_GET['id_realisasi_apbdes'];
$sql = "SELECT * FROM tb_realisasi_apbdes WHERE id_realisasi_apbdes= '$id_realisasi_apbdes'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$realisasi_apbdes = $data['realisasi_apbdes'];
		$foto1 = $data['foto_apbdes_1'];
		$foto2 = $data['foto_apbdes_2'];
		$foto3 = $data['foto_apbdes_3'];
		$foto4 = $data['foto_apbdes_4'];
		unlink("file/apbdes/".$realisasi_apbdes);
		unlink("file/foto/foto1/".$foto1);
		unlink("file/foto/foto2/".$foto2);
		unlink("file/foto/foto3/".$foto3);
		unlink("file/foto/foto4/".$foto4);
     }
     // var_dump($realisasi_apbdes);
     // var_dump($foto1);
     // var_dump($foto2);
     // var_dump($foto3);
     // var_dump($foto4);

$id_realisasi_apbdes = mysqli_real_escape_string($koneksi,$_GET['id_realisasi_apbdes']);
$query = mysqli_query($koneksi,"DELETE FROM tb_realisasi_apbdes WHERE id_realisasi_apbdes='$id_realisasi_apbdes' ");
header('location:../../../index.php?page=p_apbdes');
?>