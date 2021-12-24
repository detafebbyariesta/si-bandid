<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_rpjmdes = $_POST['id_rpjmdes'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_rpjmdes SET  validasi='$validasi', catatan='$catatan' WHERE id_rpjmdes='$id_rpjmdes'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=rpjmdes");
      }
}
 ?>