<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_omspan = $_POST['id_omspan'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$omspan = $_FILES['omspan']['name'];

//cek dulu jika file jalankan coding ini
  if($omspan != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $omspan); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_omspan_tmp = $_FILES['omspan']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $omspanExt = substr($omspan, strrpos($omspan, '.')); 
    $omspanExt = str_replace('.','',$omspanExt); // Extension
    $omspan = preg_replace("/\.[^.\s]{3,4}$/", "", $omspan); 
    $nama_omspan_baru = "omspan_".$acak.'.'.$omspanExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_omspan_tmp, 'file/omspan/'.$nama_omspan_baru)){
      // Query untuk menampilkan data omspan berdasarkan id_omspan yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_omspan WHERE id_omspan='".$id_omspan."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/omspan/".$data['omspan'])) // Jika file ada
        unlink("file/omspan/".$data['omspan']); // Hapus file sebelumnya yang ada di folder omspan
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_omspan SET  omspan='$nama_omspan_baru',validasi='$validasi',catatan='$catatan' WHERE id_omspan='$id_omspan'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=omspan");

}
?>