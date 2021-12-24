<?php
include "../../../asset/inc/config.php";
$id_smt_1 = $_GET['id_smt_1'];
$sql = "SELECT * FROM tb_smt_1 WHERE id_smt_1= '$id_smt_1'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$smt_1 = $data['smt_1'];
		unlink("file/smt_1/".$smt_1);
     }
$id_smt_1 = mysqli_real_escape_string($koneksi,$_GET['id_smt_1']);
$query = mysqli_query($koneksi,"DELETE FROM tb_smt_1 WHERE id_smt_1='$id_smt_1' ");
header('location:../../../index.php?page=smt1');
?>