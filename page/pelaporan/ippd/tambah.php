<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $ippd = $_FILES['ippd']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
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
      move_uploaded_file($file_ippd_tmp, 'file/ippd/'.$nama_ippd_baru); //memindah file ke folder file/ippd
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_ippd(ippd,id_user,validasi,tahun) VALUES('$nama_ippd_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=ippd");

}
?>