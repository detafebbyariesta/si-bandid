<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_sk = $_POST['id_sk'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$sk = $_FILES['sk']['name'];

//cek dulu jika file jalankan coding ini
  if($sk != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $sk); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_sk_tmp = $_FILES['sk']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $skExt = substr($sk, strrpos($sk, '.')); 
    $skExt = str_replace('.','',$skExt); // Extension
    $sk = preg_replace("/\.[^.\s]{3,4}$/", "", $sk); 
    $nama_sk_baru = "SK_".$acak.'.'.$skExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_sk_tmp, 'file/sk/'.$nama_sk_baru)){
      // Query untuk menampilkan data sk berdasarkan id_sk yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_sk WHERE id_sk='".$id_sk."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/sk/".$data['sk'])) // Jika file ada
        unlink("file/sk/".$data['sk']); // Hapus file sebelumnya yang ada di folder sk
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_sk SET  sk='$nama_sk_baru',validasi='$validasi',catatan='$catatan' WHERE id_sk='$id_sk'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=sk");

}
?>