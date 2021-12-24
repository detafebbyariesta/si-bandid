<?php
include "../../../asset/inc/config.php";
$id_apbdes = $_GET['id_apbdes'];
$sql = "SELECT * FROM tb_apbdes WHERE id_apbdes= '$id_apbdes'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$apbdes = $data['apbdes'];
		$perdes = $data['perdes'];
		$perkades = $data['perkades'];
		unlink("file/apbdes/".$apbdes);
		unlink("file/perdes/".$perdes);
		unlink("file/perkades/".$perkades);
     }
$id_apbdes = mysqli_real_escape_string($koneksi,$_GET['id_apbdes']);
$query = mysqli_query($koneksi,"DELETE FROM tb_apbdes WHERE id_apbdes='$id_apbdes' ");
header('location:../../../index.php?page=apbdes');
?>