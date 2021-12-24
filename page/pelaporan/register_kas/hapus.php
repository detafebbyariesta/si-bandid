<?php
include "../../../asset/inc/config.php";
$id_tutup_kas = $_GET['id_tutup_kas'];
$sql = "SELECT * FROM tb_tutup_kas WHERE id_tutup_kas= '$id_tutup_kas'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$tutup_kas = $data['tutup_kas'];
		unlink("file/register_kas/".$tutup_kas);
     }
$id_tutup_kas = mysqli_real_escape_string($koneksi,$_GET['id_tutup_kas']);
$query = mysqli_query($koneksi,"DELETE FROM tb_tutup_kas WHERE id_tutup_kas='$id_tutup_kas' ");
header('location:../../../index.php?page=register_kas');
?>