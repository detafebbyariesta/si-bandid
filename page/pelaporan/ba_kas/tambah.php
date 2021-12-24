<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $ba_kas = $_FILES['ba_kas']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];
    $bulan = $_POST['bln'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($ba_kas != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $ba_kas); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_ba_kas_tmp = $_FILES['ba_kas']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $ba_kasExt = substr($ba_kas, strrpos($ba_kas, '.')); 
    $ba_kasExt = str_replace('.','',$ba_kasExt); // Extension
    $ba_kas = preg_replace("/\.[^.\s]{3,4}$/", "", $ba_kas); 
    $nama_ba_kas_baru = "ba_kas_".$acak.'.'.$ba_kasExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_ba_kas_tmp, 'file/ba_kas/'.$nama_ba_kas_baru); //memindah file ke folder file/ba_kas
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_ba_kas(ba_kas,id_user,validasi,tahun,bulan) VALUES('$nama_ba_kas_baru','$id_user','$valid','$tahun','$bulan')");

        // Show message when user added
        header("Location:../../../index.php?page=ba_kas");

}
?>