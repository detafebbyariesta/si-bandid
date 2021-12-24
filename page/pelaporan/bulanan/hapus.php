<?php
include "../../../asset/inc/config.php";
$id_bulanan = $_GET['id_bulanan'];
$sql = "SELECT * FROM tb_bulanan WHERE id_bulanan= '$id_bulanan'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$bulanan = $data['bulanan'];
		unlink("file/bulanan/".$bulanan);
     }
$id_bulanan = mysqli_real_escape_string($koneksi,$_GET['id_bulanan']);
$query = mysqli_query($koneksi,"DELETE FROM tb_bulanan WHERE id_bulanan='$id_bulanan' ");
header('location:../../../index.php?page=bulanan');
?>