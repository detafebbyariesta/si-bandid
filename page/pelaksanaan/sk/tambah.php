<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $sk = $_FILES['sk']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($sk != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $sk); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_sk_tmp = $_FILES['sk']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $skExt = substr($sk, strrpos($sk, '.')); 
    $skExt = str_replace('.','',$skExt); // Extension
    $sk = preg_replace("/\.[^.\s]{3,4}$/", "", $sk); 
    $nama_sk_baru = "SK_".$acak.'.'.$skExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_sk_tmp, 'file/sk/'.$nama_sk_baru); //memindah file ke folder file/sk
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_sk(sk,id_user,validasi,tahun) VALUES('$nama_sk_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=sk");

}
?>