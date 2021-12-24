<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $rpd = $_FILES['rpd']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
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
      move_uploaded_file($file_rpd_tmp, 'file/rpd/'.$nama_rpd_baru); //memindah file ke folder file/rpd
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_rpd(rpd,id_user,validasi,tahun) VALUES('$nama_rpd_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=rpd");

}
?>