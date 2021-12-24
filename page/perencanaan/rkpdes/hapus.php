<?php
include "../../../asset/inc/config.php";
$id_rkpdes = $_GET['id_rkpdes'];
$sql = "SELECT * FROM tb_rkpdes WHERE id_rkpdes= '$id_rkpdes'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$rkpdes = $data['rkpdes'];
		$perdes = $data['perdes'];
		unlink("file/rkpdes/".$rkpdes);
		unlink("file/perdes/".$perdes);
     }
$id_rkpdes = mysqli_real_escape_string($koneksi,$_GET['id_rkpdes']);
$query = mysqli_query($koneksi,"DELETE FROM tb_rkpdes WHERE id_rkpdes='$id_rkpdes' ");
header('location:../../../index.php?page=rkpdes');
?>