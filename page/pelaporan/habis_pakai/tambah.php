<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $habis_pakai = $_FILES['habis_pakai']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($habis_pakai != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $habis_pakai); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_habis_pakai_tmp = $_FILES['habis_pakai']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $habis_pakaiExt = substr($habis_pakai, strrpos($habis_pakai, '.')); 
    $habis_pakaiExt = str_replace('.','',$habis_pakaiExt); // Extension
    $habis_pakai = preg_replace("/\.[^.\s]{3,4}$/", "", $habis_pakai); 
    $nama_habis_pakai_baru = "habis_pakai_".$acak.'.'.$habis_pakaiExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_habis_pakai_tmp, 'file/habis_pakai/'.$nama_habis_pakai_baru); //memindah file ke folder file/habis_pakai
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_habis_pakai(habis_pakai,id_user,validasi,tahun) VALUES('$nama_habis_pakai_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=habis_pakai");

}
?>