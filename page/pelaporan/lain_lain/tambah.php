<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $lain_lain = $_FILES['lain_lain']['name'];
    $ket = $_POST['ket'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($lain_lain != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file yang bisa diupload 
    $x = explode('.', $lain_lain); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_lain_lain_tmp = $_FILES['lain_lain']['tmp_name']; 
    $acak = rand(00000000, 99999999);
    $lain_lainExt = substr($lain_lain, strrpos($lain_lain, '.')); 
    $lain_lainExt = str_replace('.','',$lain_lainExt); // Extension
    $lain_lain = preg_replace("/\.[^.\s]{3,4}$/", "", $lain_lain); 
    $nama_lain_lain_baru = "lain_lain_".$acak.'.'.$lain_lainExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_lain_lain_tmp, 'file/lain_lain/'.$nama_lain_lain_baru); //memindah file ke folder file/p_dd
    }
  }
        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_lain(lain_lain,id_user,validasi,tahun,keterangan) VALUES('$nama_lain_lain_baru','$id_user','$valid','$tahun','$ket')");
        
        header("Location:../../../index.php?page=lain_lain");

}
?>