<?php
include "../../../asset/inc/config.php";
$id_omspan = $_GET['id_omspan'];
$sql = "SELECT * FROM tb_omspan WHERE id_omspan= '$id_omspan'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$omspan = $data['omspan'];
		unlink("file/omspan/".$omspan);
     }
$id_omspan = mysqli_real_escape_string($koneksi,$_GET['id_omspan']);
$query = mysqli_query($koneksi,"DELETE FROM tb_omspan WHERE id_omspan='$id_omspan' ");
header('location:../../../index.php?page=omspan');
?>