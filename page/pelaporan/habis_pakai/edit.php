<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_habis_pakai = $_POST['id_habis_pakai'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$habis_pakai = $_FILES['habis_pakai']['name'];

//cek dulu jika file jalankan coding ini
  if($habis_pakai != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $habis_pakai); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_habis_pakai_tmp = $_FILES['habis_pakai']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $habis_pakaiExt = substr($habis_pakai, strrpos($habis_pakai, '.')); 
    $habis_pakaiExt = str_replace('.','',$habis_pakaiExt); // Extension
    $habis_pakai = preg_replace("/\.[^.\s]{3,4}$/", "", $habis_pakai); 
    $nama_habis_pakai_baru = "habis_pakai_".$acak.'.'.$habis_pakaiExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_habis_pakai_tmp, 'file/habis_pakai/'.$nama_habis_pakai_baru)){
      // Query untuk menampilkan data habis_pakai berdasarkan id_habis_pakai yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_habis_pakai WHERE id_habis_pakai='".$id_habis_pakai."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/habis_pakai/".$data['habis_pakai'])) // Jika file ada
        unlink("file/habis_pakai/".$data['habis_pakai']); // Hapus file sebelumnya yang ada di folder habis_pakai
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_habis_pakai SET  habis_pakai='$nama_habis_pakai_baru',validasi='$validasi',catatan='$catatan' WHERE id_habis_pakai='$id_habis_pakai'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=habis_pakai");

}
?>