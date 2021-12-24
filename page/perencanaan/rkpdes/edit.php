<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_rkpdes = $_POST['id_rkpdes'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $rkpdes = $_FILES['rkpdes']['name'];
  $perdes = $_FILES['perdes']['name'];

//cek dulu jika file jalankan coding ini
  if($rkpdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $rkpdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_rkpdes_tmp = $_FILES['rkpdes']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $rkpdesExt = substr($rkpdes, strrpos($rkpdes, '.')); 
    $rkpdesExt = str_replace('.','',$rkpdesExt); // Extension
    $rkpdes = preg_replace("/\.[^.\s]{3,4}$/", "", $rkpdes); 
    $nama_rkpdes_baru = "RKPDes_".$acak.'.'.$rkpdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_rkpdes_tmp, 'file/rkpdes/'.$nama_rkpdes_baru)){
      // Query untuk menampilkan data rkpdes berdasarkan id_rkpdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_rkpdes WHERE id_rkpdes='".$id_rkpdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/rkpdes/".$data['rkpdes'])) // Jika file ada
        unlink("file/rkpdes/".$data['rkpdes']); // Hapus file sebelumnya yang ada di folder rkpdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_rkpdes SET  rkpdes='$nama_rkpdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_rkpdes='$id_rkpdes'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($perdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $perdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_perdes_tmp = $_FILES['perdes']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $perdesExt = substr($perdes, strrpos($perdes, '.')); 
    $perdesExt = str_replace('.','',$perdesExt); // Extension
    $perdes = preg_replace("/\.[^.\s]{3,4}$/", "", $perdes);  
    $nama_perdes_baru = "PERDes_".$acak.'.'.$perdesExt; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_perdes_tmp, 'file/perdes/'.$nama_perdes_baru)){
      // Query untuk menampilkan data perdes berdasarkan id_rkpdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_rkpdes WHERE id_rkpdes='".$id_rkpdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/perdes/".$data['perdes'])) // Jika file ada
        unlink("file/perdes/".$data['perdes']); // Hapus file sebelumnya yang ada di folder perdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_rkpdes SET perdes='$nama_perdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_rkpdes='$id_rkpdes'");
      }
    }
  }
        // Show message when user added
        header("Location:../../../index.php?page=rkpdes");
}
?>