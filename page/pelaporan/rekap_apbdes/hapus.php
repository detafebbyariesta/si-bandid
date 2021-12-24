<?php
include "../../../asset/inc/config.php";
$id_rekap_realisasi_apbdes = $_GET['id_rekap_realisasi_apbdes'];
$sql = "SELECT * FROM tb_rekap_realisasi_apbdes WHERE id_rekap_realisasi_apbdes= '$id_rekap_realisasi_apbdes'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$rekap_realisasi_apbdes = $data['rekap_realisasi_apbdes'];
		unlink("file/rekap_apbdes/".$rekap_realisasi_apbdes);
     }
$id_rekap_realisasi_apbdes = mysqli_real_escape_string($koneksi,$_GET['id_rekap_realisasi_apbdes']);
$query = mysqli_query($koneksi,"DELETE FROM tb_rekap_realisasi_apbdes WHERE id_rekap_realisasi_apbdes='$id_rekap_realisasi_apbdes' ");
header('location:../../../index.php?page=rekap_apbdes');
?>