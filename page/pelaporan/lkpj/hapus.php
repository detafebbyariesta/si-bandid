<?php
include "../../../asset/inc/config.php";
$id_lkpj = $_GET['id_lkpj'];
$sql = "SELECT * FROM tb_lkpj WHERE id_lkpj= '$id_lkpj'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$lkpj = $data['lkpj'];
		unlink("file/lkpj/".$lkpj);
     }
$id_lkpj = mysqli_real_escape_string($koneksi,$_GET['id_lkpj']);
$query = mysqli_query($koneksi,"DELETE FROM tb_lkpj WHERE id_lkpj='$id_lkpj' ");
header('location:../../../index.php?page=lkpj');
?>