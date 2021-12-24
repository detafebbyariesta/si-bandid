<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_smt_2 = $_POST['id_smt_2'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$smt_2 = $_FILES['smt_2']['name'];

//cek dulu jika file jalankan coding ini
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
      if (move_uploaded_file($file_smt_2_tmp, 'file/smt_2/'.$nama_smt_2_baru)){
      // Query untuk menampilkan data smt_2 berdasarkan id_smt_2 yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_smt_2 WHERE id_smt_2='".$id_smt_2."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/smt_2/".$data['smt_2'])) // Jika file ada
        unlink("file/smt_2/".$data['smt_2']); // Hapus file sebelumnya yang ada di folder smt_2
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_smt_2 SET  smt_2='$nama_smt_2_baru',validasi='$validasi',catatan='$catatan' WHERE id_smt_2='$id_smt_2'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=smt2");

}
?>