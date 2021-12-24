<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_apbdes = $_POST['id_apbdes'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_apbdes SET  validasi='$validasi', catatan='$catatan' WHERE id_apbdes='$id_apbdes'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=apbdes");
      }
}
 ?>