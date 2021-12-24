<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_ippd = $_POST['id_ippd'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_ippd SET  validasi='$validasi', catatan='$catatan' WHERE id_ippd='$id_ippd'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=ippd");
      }
}
 ?>