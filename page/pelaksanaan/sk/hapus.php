<?php
include "../../../asset/inc/config.php";
$id_sk = $_GET['id_sk'];
$sql = "SELECT * FROM tb_sk WHERE id_sk= '$id_sk'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$sk = $data['sk'];
		unlink("file/sk/".$sk);
     }
$id_sk = mysqli_real_escape_string($koneksi,$_GET['id_sk']);
$query = mysqli_query($koneksi,"DELETE FROM tb_sk WHERE id_sk='$id_sk' ");
header('location:../../../index.php?page=sk');
?>