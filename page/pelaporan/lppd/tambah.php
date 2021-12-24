<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $lppd = $_FILES['lppd']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
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
      move_uploaded_file($file_lppd_tmp, 'file/lppd/'.$nama_lppd_baru); //memindah file ke folder file/lppd
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_lppd(lppd,id_user,validasi,tahun) VALUES('$nama_lppd_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=lppd");

}
?>