<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $bulanan = $_FILES['bulanan']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];
    $bulan = $_POST['bln'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($bulanan != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $bulanan); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_bulanan_tmp = $_FILES['bulanan']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $bulananExt = substr($bulanan, strrpos($bulanan, '.')); 
    $bulananExt = str_replace('.','',$bulananExt); // Extension
    $bulanan = preg_replace("/\.[^.\s]{3,4}$/", "", $bulanan); 
    $nama_bulanan_baru = "Bulanan_".$acak.'.'.$bulananExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_bulanan_tmp, 'file/bulanan/'.$nama_bulanan_baru); //memindah file ke folder file/bulanan
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_bulanan(bulanan,id_user,validasi,tahun,bulan) VALUES('$nama_bulanan_baru','$id_user','$valid','$tahun','$bulan')");

        // Show message when user added
        header("Location:../../../index.php?page=bulanan");

}
?>