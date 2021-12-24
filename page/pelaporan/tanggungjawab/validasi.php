<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_tanggung_jawab = $_POST['id_tanggung_jawab'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_tanggung_jawab SET  validasi='$validasi', catatan='$catatan' WHERE id_tanggung_jawab='$id_tanggung_jawab'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=tanggungjawab");
      }
}
 ?>