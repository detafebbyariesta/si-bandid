<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_lkpj = $_POST['id_lkpj'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_lkpj SET  validasi='$validasi', catatan='$catatan' WHERE id_lkpj='$id_lkpj'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=lkpj");
      }
}
 ?>