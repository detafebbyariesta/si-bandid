<?php
include "../../../asset/inc/config.php";
$id_rpjmdes = $_GET['id_rpjmdes'];
$sql = "SELECT * FROM tb_rpjmdes WHERE id_rpjmdes= '$id_rpjmdes'";
$result = mysqli_query($koneksi,$sql);
while($data = mysqli_fetch_assoc($result))
     { 
		$rpjmdes = $data['rpjmdes'];
		$perdes = $data['perdes'];
		unlink("file/rpjmdes/".$rpjmdes);
		unlink("file/perdes/".$perdes);
     }
$id_rpjmdes = mysqli_real_escape_string($koneksi,$_GET['id_rpjmdes']);
$query = mysqli_query($koneksi,"DELETE FROM tb_rpjmdes WHERE id_rpjmdes='$id_rpjmdes' ");
header('location:../../../index.php?page=rpjmdes');
?>