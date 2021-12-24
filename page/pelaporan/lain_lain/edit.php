<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_lain_lain = $_POST['id_lain_lain'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $keterangan = $_POST['keterang'];
  $lain_lain = $_FILES['lain_lain']['name'];

//cek dulu jika file jalankan coding ini
  if($lain_lain != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $lain_lain); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_lain_lain_tmp = $_FILES['lain_lain']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $lain_lainExt = substr($lain_lain, strrpos($lain_lain, '.')); 
    $lain_lainExt = str_replace('.','',$lain_lainExt); // Extension
    $lain_lain = preg_replace("/\.[^.\s]{3,4}$/", "", $lain_lain); 
    $nama_lain_lain_baru = "lain_lain_".$acak.'.'.$lain_lainExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_lain_lain_tmp, 'file/lain_lain/'.$nama_lain_lain_baru)){
      // Query untuk menampilkan data
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_lain WHERE id_lain_lain='".$id_lain_lain."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/lain_lain/".$data['lain_lain'])) // Jika file ada
        unlink("file/lain_lain/".$data['lain_lain']); // Hapus file sebelumnya yang ada di folder realisasi_dd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_lain SET lain_lain='$nama_lain_lain_baru',validasi='$validasi',catatan='$catatan' WHERE id_lain_lain='$id_lain_lain'");
      }
    }
  }


  if ($keterangan != "") {
    $result = mysqli_query($koneksi, "UPDATE tb_lain SET validasi='$validasi',catatan='$catatan',keterangan='$keterangan' WHERE id_lain_lain='$id_lain_lain'");
  }
        // Show message when user lain_lained
        header("Location:../../../index.php?page=lain_lain");
}
?>