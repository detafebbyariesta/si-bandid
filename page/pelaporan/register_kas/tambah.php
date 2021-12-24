<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $tutup_kas = $_FILES['tutup_kas']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($tutup_kas != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $tutup_kas); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_tutup_kas_tmp = $_FILES['tutup_kas']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $tutup_kasExt = substr($tutup_kas, strrpos($tutup_kas, '.')); 
    $tutup_kasExt = str_replace('.','',$tutup_kasExt); // Extension
    $tutup_kas = preg_replace("/\.[^.\s]{3,4}$/", "", $tutup_kas); 
    $nama_tutup_kas_baru = "register_kas_".$acak.'.'.$tutup_kasExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_tutup_kas_tmp, 'file/register_kas/'.$nama_tutup_kas_baru); //memindah file ke folder file/tutup_kas
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_tutup_kas(tutup_kas,id_user,validasi,tahun) VALUES('$nama_tutup_kas_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=register_kas");

}
?>