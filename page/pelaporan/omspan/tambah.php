<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $omspan = $_FILES['omspan']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($omspan != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $omspan); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_omspan_tmp = $_FILES['omspan']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $omspanExt = substr($omspan, strrpos($omspan, '.')); 
    $omspanExt = str_replace('.','',$omspanExt); // Extension
    $omspan = preg_replace("/\.[^.\s]{3,4}$/", "", $omspan); 
    $nama_omspan_baru = "omspan_".$acak.'.'.$omspanExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_omspan_tmp, 'file/omspan/'.$nama_omspan_baru); //memindah file ke folder file/omspan
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_omspan(omspan,id_user,validasi,tahun) VALUES('$nama_omspan_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=omspan");

}
?>