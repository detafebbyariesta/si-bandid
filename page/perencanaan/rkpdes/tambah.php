<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $rkpdes = $_FILES['rkpdes']['name'];
    $perdes = $_FILES['perdes']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($rkpdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file yang bisa diupload 
    $x = explode('.', $rkpdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_rkpdes_tmp = $_FILES['rkpdes']['tmp_name']; 
    $acak = rand(00000000, 99999999);
    $rkpdesExt = substr($rkpdes, strrpos($rkpdes, '.')); 
    $rkpdesExt = str_replace('.','',$rkpdesExt); // Extension
    $rkpdes = preg_replace("/\.[^.\s]{3,4}$/", "", $rkpdes); 
    $nama_rkpdes_baru = "RKPDes_".$acak.'.'.$rkpdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_rkpdes_tmp, 'file/rkpdes/'.$nama_rkpdes_baru); //memindah file ke folder file/rkpdes
    }
  }

  //cek dulu jika ada gambar produk jalankan coding ini
  if($perdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file yang bisa diupload 
    $x = explode('.', $perdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_perdes_tmp = $_FILES['perdes']['tmp_name'];
    $acak = rand(00000000, 99999999);
    $perdesExt = substr($perdes, strrpos($perdes, '.')); 
    $perdesExt = str_replace('.','',$perdesExt); // Extension
    $perdes = preg_replace("/\.[^.\s]{3,4}$/", "", $perdes);  
    $nama_perdes_baru = "PERDes_".$acak.'.'.$perdesExt; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_perdes_tmp, 'file/perdes/'.$nama_perdes_baru); //memindah file ke folder file/perdes
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_rkpdes(rkpdes,perdes,id_user,validasi,tahun) VALUES('$nama_rkpdes_baru','$nama_perdes_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=rkpdes");

}
?>