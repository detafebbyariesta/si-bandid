<?php
include "../../../asset/inc/config.php";
$id_lain_lain = $_GET['id_lain_lain'];
$sql = "SELECT * FROM tb_lain WHERE id_lain_lain= '$id_lain_lain'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$lain_lain = $data['lain_lain'];
		unlink("file/lain_lain/".$lain_lain);
     }

$id_lain_lain = mysqli_real_escape_string($koneksi,$_GET['id_lain_lain']);
$query = mysqli_query($koneksi,"DELETE FROM tb_lain WHERE id_lain_lain='$id_lain_lain' ");
header('location:../../../index.php?page=lain_lain');
?>