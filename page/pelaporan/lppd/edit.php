<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_lppd = $_POST['id_lppd'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$lppd = $_FILES['lppd']['name'];

//cek dulu jika file jalankan coding ini
  if($lppd != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $lppd); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_lppd_tmp = $_FILES['lppd']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $lppdExt = substr($lppd, strrpos($lppd, '.')); 
    $lppdExt = str_replace('.','',$lppdExt); // Extension
    $lppd = preg_replace("/\.[^.\s]{3,4}$/", "", $lppd); 
    $nama_lppd_baru = "lppd_".$acak.'.'.$lppdExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_lppd_tmp, 'file/lppd/'.$nama_lppd_baru)){
      // Query untuk menampilkan data lppd berdasarkan id_lppd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_lppd WHERE id_lppd='".$id_lppd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/lppd/".$data['lppd'])) // Jika file ada
        unlink("file/lppd/".$data['lppd']); // Hapus file sebelumnya yang ada di folder lppd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_lppd SET  lppd='$nama_lppd_baru',validasi='$validasi',catatan='$catatan' WHERE id_lppd='$id_lppd'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=lppd");

}
?>