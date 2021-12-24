<?php
include "../../../asset/inc/config.php";
$id_retribusi = $_GET['id_retribusi'];
$sql = "SELECT * FROM tb_retribusi WHERE id_retribusi= '$id_retribusi'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$retribusi = $data['retribusi'];
		$foto1 = $data['foto1'];
		$foto2 = $data['foto2'];
		$foto3 = $data['foto3'];
		$foto4 = $data['foto4'];
		unlink("file/retribusi/".$retribusi);
		unlink("file/foto/foto1/".$foto1);
		unlink("file/foto/foto2/".$foto2);
		unlink("file/foto/foto3/".$foto3);
		unlink("file/foto/foto4/".$foto4);
     }
     // var_dump($retribusi);
     // var_dump($foto1);
     // var_dump($foto2);
     // var_dump($foto3);
     // var_dump($foto4);

$id_retribusi = mysqli_real_escape_string($koneksi,$_GET['id_retribusi']);
$query = mysqli_query($koneksi,"DELETE FROM tb_retribusi WHERE id_retribusi='$id_retribusi' ");
header('location:../../../index.php?page=retribusi');
?>