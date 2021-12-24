<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $lkpj = $_FILES['lkpj']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($lkpj != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $lkpj); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_lkpj_tmp = $_FILES['lkpj']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $lkpjExt = substr($lkpj, strrpos($lkpj, '.')); 
    $lkpjExt = str_replace('.','',$lkpjExt); // Extension
    $lkpj = preg_replace("/\.[^.\s]{3,4}$/", "", $lkpj); 
    $nama_lkpj_baru = "lkpj_".$acak.'.'.$lkpjExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_lkpj_tmp, 'file/lkpj/'.$nama_lkpj_baru); //memindah file ke folder file/lkpj
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_lkpj(lkpj,id_user,validasi,tahun) VALUES('$nama_lkpj_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=lkpj");

}
?>