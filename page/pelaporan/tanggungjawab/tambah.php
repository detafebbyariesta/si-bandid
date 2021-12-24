<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $tanggung_jawab = $_FILES['tanggung_jawab']['name'];
    $perdes = $_FILES['perdes']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($tanggung_jawab != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file yang bisa diupload 
    $x = explode('.', $tanggung_jawab); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_tanggung_jawab_tmp = $_FILES['tanggung_jawab']['tmp_name']; 
    $acak = rand(00000000, 99999999);
    $tanggung_jawabExt = substr($tanggung_jawab, strrpos($tanggung_jawab, '.')); 
    $tanggung_jawabExt = str_replace('.','',$tanggung_jawabExt); // Extension
    $tanggung_jawab = preg_replace("/\.[^.\s]{3,4}$/", "", $tanggung_jawab); 
    $nama_tanggung_jawab_baru = "Tanggungjawab_".$acak.'.'.$tanggung_jawabExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_tanggung_jawab_tmp, 'file/tanggungjawab/'.$nama_tanggung_jawab_baru); //memindah file ke folder file/tanggung_jawab
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
        $result = mysqli_query($koneksi, "INSERT INTO tb_tanggung_jawab(tanggung_jawab,perdes,id_user,validasi,tahun) VALUES('$nama_tanggung_jawab_baru','$nama_perdes_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=tanggungjawab");

}
?>