<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_bulanan = $_POST['id_bulanan'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_bulanan SET  validasi='$validasi', catatan='$catatan' WHERE id_bulanan='$id_bulanan'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=bulanan");
      }
}
 ?>