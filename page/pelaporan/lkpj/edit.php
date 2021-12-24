<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_lkpj = $_POST['id_lkpj'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$lkpj = $_FILES['lkpj']['name'];

//cek dulu jika file jalankan coding ini
  if($lkpj != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $lkpj); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_lkpj_tmp = $_FILES['lkpj']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $lkpjExt = substr($lkpj, strrpos($lkpj, '.')); 
    $lkpjExt = str_replace('.','',$lkpjExt); // Extension
    $lkpj = preg_replace("/\.[^.\s]{3,4}$/", "", $lkpj); 
    $nama_lkpj_baru = "lkpj_".$acak.'.'.$lkpjExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_lkpj_tmp, 'file/lkpj/'.$nama_lkpj_baru)){
      // Query untuk menampilkan data lkpj berdasarkan id_lkpj yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_lkpj WHERE id_lkpj='".$id_lkpj."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/lkpj/".$data['lkpj'])) // Jika file ada
        unlink("file/lkpj/".$data['lkpj']); // Hapus file sebelumnya yang ada di folder lkpj
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_lkpj SET  lkpj='$nama_lkpj_baru',validasi='$validasi',catatan='$catatan' WHERE id_lkpj='$id_lkpj'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=lkpj");

}
?>