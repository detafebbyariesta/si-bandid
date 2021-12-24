<?php
include "../../../asset/inc/config.php";
$id_realisasi_apbdes_dana = $_GET['id_realisasi_apbdes_dana'];
$sql = "SELECT * FROM tb_realisasi_apbdes_dana WHERE id_realisasi_apbdes_dana= '$id_realisasi_apbdes_dana'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$realisasi_apbdes_dana = $data['realisasi_apbdes_dana'];
		unlink("file/rekap_sumberdana/".$realisasi_apbdes_dana);
     }
$id_realisasi_apbdes_dana = mysqli_real_escape_string($koneksi,$_GET['id_realisasi_apbdes_dana']);
$query = mysqli_query($koneksi,"DELETE FROM tb_realisasi_apbdes_dana WHERE id_realisasi_apbdes_dana='$id_realisasi_apbdes_dana' ");
header('location:../../../index.php?page=rekap_sumberdana');
?>