<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_rpd = $_POST['id_rpd'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$rpd = $_FILES['rpd']['name'];

//cek dulu jika file jalankan coding ini
  if($rpd != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $rpd); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_rpd_tmp = $_FILES['rpd']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $rpdExt = substr($rpd, strrpos($rpd, '.')); 
    $rpdExt = str_replace('.','',$rpdExt); // Extension
    $rpd = preg_replace("/\.[^.\s]{3,4}$/", "", $rpd); 
    $nama_rpd_baru = "RPD_".$acak.'.'.$rpdExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_rpd_tmp, 'file/rpd/'.$nama_rpd_baru)){
      // Query untuk menampilkan data rpd berdasarkan id_rpd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_rpd WHERE id_rpd='".$id_rpd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/rpd/".$data['rpd'])) // Jika file ada
        unlink("file/rpd/".$data['rpd']); // Hapus file sebelumnya yang ada di folder rpd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_rpd SET  rpd='$nama_rpd_baru',validasi='$validasi',catatan='$catatan' WHERE id_rpd='$id_rpd'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=rpd");

}
?>