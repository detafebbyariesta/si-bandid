<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_rkpdes = $_POST['id_rkpdes'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_rkpdes SET  validasi='$validasi', catatan='$catatan' WHERE id_rkpdes='$id_rkpdes'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=rkpdes");
      }
}
 ?>