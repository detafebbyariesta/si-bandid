<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_ippd = $_POST['id_ippd'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$ippd = $_FILES['ippd']['name'];

//cek dulu jika file jalankan coding ini
  if($ippd != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $ippd); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_ippd_tmp = $_FILES['ippd']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $ippdExt = substr($ippd, strrpos($ippd, '.')); 
    $ippdExt = str_replace('.','',$ippdExt); // Extension
    $ippd = preg_replace("/\.[^.\s]{3,4}$/", "", $ippd); 
    $nama_ippd_baru = "ippd_".$acak.'.'.$ippdExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_ippd_tmp, 'file/ippd/'.$nama_ippd_baru)){
      // Query untuk menampilkan data ippd berdasarkan id_ippd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_ippd WHERE id_ippd='".$id_ippd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/ippd/".$data['ippd'])) // Jika file ada
        unlink("file/ippd/".$data['ippd']); // Hapus file sebelumnya yang ada di folder ippd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_ippd SET  ippd='$nama_ippd_baru',validasi='$validasi',catatan='$catatan' WHERE id_ippd='$id_ippd'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=ippd");

}
?>