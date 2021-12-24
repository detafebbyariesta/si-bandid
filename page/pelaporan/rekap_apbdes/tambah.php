<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $rekap_realisasi_apbdes = $_FILES['rekap_realisasi_apbdes']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada gambar produk jalankan coding ini
  if($rekap_realisasi_apbdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $rekap_realisasi_apbdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_rekap_realisasi_apbdes_tmp = $_FILES['rekap_realisasi_apbdes']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $rekap_realisasi_apbdesExt = substr($rekap_realisasi_apbdes, strrpos($rekap_realisasi_apbdes, '.')); 
    $rekap_realisasi_apbdesExt = str_replace('.','',$rekap_realisasi_apbdesExt); // Extension
    $rekap_realisasi_apbdes = preg_replace("/\.[^.\s]{3,4}$/", "", $rekap_realisasi_apbdes); 
    $nama_rekap_realisasi_apbdes_baru = "rekap_apbdes_".$acak.'.'.$rekap_realisasi_apbdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_rekap_realisasi_apbdes_tmp, 'file/rekap_apbdes/'.$nama_rekap_realisasi_apbdes_baru); //memindah file ke folder file/rekap_realisasi_apbdes
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_rekap_realisasi_apbdes(rekap_realisasi_apbdes,id_user,validasi,tahun) VALUES('$nama_rekap_realisasi_apbdes_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=rekap_apbdes");

}
?>