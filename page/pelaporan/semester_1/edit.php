<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_smt_1 = $_POST['id_smt_1'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$smt_1 = $_FILES['smt_1']['name'];

//cek dulu jika file jalankan coding ini
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
      if (move_uploaded_file($file_smt_1_tmp, 'file/smt_1/'.$nama_smt_1_baru)){
      // Query untuk menampilkan data smt_1 berdasarkan id_smt_1 yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_smt_1 WHERE id_smt_1='".$id_smt_1."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/smt_1/".$data['smt_1'])) // Jika file ada
        unlink("file/smt_1/".$data['smt_1']); // Hapus file sebelumnya yang ada di folder smt_1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_smt_1 SET  smt_1='$nama_smt_1_baru',validasi='$validasi',catatan='$catatan' WHERE id_smt_1='$id_smt_1'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=smt1");

}
?>