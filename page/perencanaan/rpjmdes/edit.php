<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_rpjmdes = $_POST['id_rpjmdes'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $rpjmdes = $_FILES['rpjmdes']['name'];
  $perdes = $_FILES['perdes']['name'];

//cek dulu jika file jalankan coding ini
  if($rpjmdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $rpjmdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_rpjmdes_tmp = $_FILES['rpjmdes']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $rpjmdesExt = substr($rpjmdes, strrpos($rpjmdes, '.')); 
    $rpjmdesExt = str_replace('.','',$rpjmdesExt); // Extension
    $rpjmdes = preg_replace("/\.[^.\s]{3,4}$/", "", $rpjmdes); 
    $nama_rpjmdes_baru = "RPJMDes_".$acak.'.'.$rpjmdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_rpjmdes_tmp, 'file/rpjmdes/'.$nama_rpjmdes_baru)){
      // Query untuk menampilkan data rpjmdes berdasarkan id_rpjmdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_rpjmdes WHERE id_rpjmdes='".$id_rpjmdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/rpjmdes/".$data['rpjmdes'])) // Jika file ada
        unlink("file/rpjmdes/".$data['rpjmdes']); // Hapus file sebelumnya yang ada di folder rpjmdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_rpjmdes SET  rpjmdes='$nama_rpjmdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_rpjmdes='$id_rpjmdes'");
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
      // Query untuk menampilkan data perdes berdasarkan id_rpjmdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_rpjmdes WHERE id_rpjmdes='".$id_rpjmdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/perdes/".$data['perdes'])) // Jika file ada
        unlink("file/perdes/".$data['perdes']); // Hapus file sebelumnya yang ada di folder perdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_rpjmdes SET perdes='$nama_perdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_rpjmdes='$id_rpjmdes'");
      }
    }
  }
        // Show message when user added
        header("Location:../../../index.php?page=rpjmdes");
}
?>