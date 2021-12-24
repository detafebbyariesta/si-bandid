<?php
include "../../../asset/inc/config.php";
$id_smt_2 = $_GET['id_smt_2'];
$sql = "SELECT * FROM tb_smt_2 WHERE id_smt_2= '$id_smt_2'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$smt_2 = $data['smt_2'];
		unlink("file/smt_2/".$smt_2);
     }
$id_smt_2 = mysqli_real_escape_string($koneksi,$_GET['id_smt_2']);
$query = mysqli_query($koneksi,"DELETE FROM tb_smt_2 WHERE id_smt_2='$id_smt_2' ");
header('location:../../../index.php?page=smt2');
?>