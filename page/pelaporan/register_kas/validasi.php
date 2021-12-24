<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_tutup_kas = $_POST['id_tutup_kas'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_tutup_kas SET  validasi='$validasi', catatan='$catatan' WHERE id_tutup_kas='$id_tutup_kas'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=register_kas");
      }
}
 ?>