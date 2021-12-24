<?php
// Check If form submitted, insert form data into users table.
if(isset($_POST['submit']))
{
    $apbdes = $_FILES['apbdes']['name'];
    $perdes = $_FILES['perdes']['name'];
    $perkades = $_FILES['perkades']['name'];
    $valid = $_POST['valid'];
    $id_user = $_POST['id_user'];
    $tahun = $_POST['tahun'];

// include database connection file
include_once("../../../asset/inc/config.php");

  //cek dulu jika ada file jalankan coding ini
  if($apbdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file yang bisa diupload 
    $x = explode('.', $apbdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_apbdes_tmp = $_FILES['apbdes']['tmp_name']; 
    $acak = rand(00000000, 99999999);
    $apbdesExt = substr($apbdes, strrpos($apbdes, '.')); 
    $apbdesExt = str_replace('.','',$apbdesExt); // Extension
    $apbdes = preg_replace("/\.[^.\s]{3,4}$/", "", $apbdes); 
    $nama_apbdes_baru = "APBDes_".$acak.'.'.$apbdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_apbdes_tmp, 'file/apbdes/'.$nama_apbdes_baru); //memindah file ke folder file/apbdes
    }
  }

  //cek dulu jika ada file jalankan coding ini
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

  //cek dulu jika ada file jalankan coding ini
  if($perkades != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file yang bisa diupload 
    $x = explode('.', $perkades); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_perkades_tmp = $_FILES['perkades']['tmp_name'];
    $acak = rand(00000000, 99999999);
    $perkadesExt = substr($perkades, strrpos($perkades, '.')); 
    $perkadesExt = str_replace('.','',$perkadesExt); // Extension
    $perkades = preg_replace("/\.[^.\s]{3,4}$/", "", $perkades);  
    $nama_perkades_baru = "PERKADes_".$acak.'.'.$perkadesExt; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      move_uploaded_file($file_perkades_tmp, 'file/perkades/'.$nama_perkades_baru); //memindah file ke folder file/perdes
    }
  }

        // Insert file into table
        $result = mysqli_query($koneksi, "INSERT INTO tb_apbdes(apbdes,perdes,perkades,id_user,validasi,tahun) VALUES('$nama_apbdes_baru','$nama_perdes_baru','$nama_perkades_baru','$id_user','$valid','$tahun')");

        // Show message when user added
        header("Location:../../../index.php?page=apbdes");

}
?>