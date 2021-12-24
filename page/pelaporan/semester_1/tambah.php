<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $smt_1 = $_FILES['smt_1']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($smt_1 != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $smt_1); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_smt_1_tmp = $_FILES['smt_1']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $smt_1Ext = substr($smt_1, strrpos($smt_1, '.')); 
    $smt_1Ext = str_replace('.','',$smt_1Ext); // Extension
    $smt_1 = preg_replace("/\.[^.\s]{3,4}$/", "", $smt_1); 
    $nama_smt_1_baru = "smt_1_".$acak.'.'.$smt_1Ext;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_smt_1_tmp, 'file/smt_1/'.$nama_smt_1_baru); //memindah file ke folder file/smt_1
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_smt_1(smt_1,id_user,validasi,tahun) VALUES('$nama_smt_1_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=smt1");

}
?>