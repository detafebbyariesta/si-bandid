<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $smt_2 = $_FILES['smt_2']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($smt_2 != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $smt_2); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_smt_2_tmp = $_FILES['smt_2']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $smt_2Ext = substr($smt_2, strrpos($smt_2, '.')); 
    $smt_2Ext = str_replace('.','',$smt_2Ext); // Extension
    $smt_2 = preg_replace("/\.[^.\s]{3,4}$/", "", $smt_2); 
    $nama_smt_2_baru = "smt_2_".$acak.'.'.$smt_2Ext;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_smt_2_tmp, 'file/smt_2/'.$nama_smt_2_baru); //memindah file ke folder file/smt_2
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_smt_2(smt_2,id_user,validasi,tahun) VALUES('$nama_smt_2_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=smt2");

}
?>