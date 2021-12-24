<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_rpd = $_POST['id_rpd'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_rpd SET  validasi='$validasi', catatan='$catatan' WHERE id_rpd='$id_rpd'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=rpd");
      }
}
 ?>