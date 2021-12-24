<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $realisasi_apbdes_dana = $_FILES['realisasi_apbdes_dana']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($realisasi_apbdes_dana != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $realisasi_apbdes_dana); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_realisasi_apbdes_dana_tmp = $_FILES['realisasi_apbdes_dana']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $realisasi_apbdes_danaExt = substr($realisasi_apbdes_dana, strrpos($realisasi_apbdes_dana, '.')); 
    $realisasi_apbdes_danaExt = str_replace('.','',$realisasi_apbdes_danaExt); // Extension
    $realisasi_apbdes_dana = preg_replace("/\.[^.\s]{3,4}$/", "", $realisasi_apbdes_dana); 
    $nama_realisasi_apbdes_dana_baru = "rekap_sumberdana_".$acak.'.'.$realisasi_apbdes_danaExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_realisasi_apbdes_dana_tmp, 'file/rekap_sumberdana/'.$nama_realisasi_apbdes_dana_baru); //memindah file ke folder file/realisasi_apbdes_dana
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_realisasi_apbdes_dana(realisasi_apbdes_dana,id_user,validasi,tahun) VALUES('$nama_realisasi_apbdes_dana_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=rekap_sumberdana");

}
?>