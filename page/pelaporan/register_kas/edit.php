<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_tutup_kas = $_POST['id_tutup_kas'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$tutup_kas = $_FILES['tutup_kas']['name'];

//cek dulu jika file jalankan coding ini
  if($tutup_kas != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $tutup_kas); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_tutup_kas_tmp = $_FILES['tutup_kas']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $tutup_kasExt = substr($tutup_kas, strrpos($tutup_kas, '.')); 
    $tutup_kasExt = str_replace('.','',$tutup_kasExt); // Extension
    $tutup_kas = preg_replace("/\.[^.\s]{3,4}$/", "", $tutup_kas); 
    $nama_tutup_kas_baru = "register_kas_".$acak.'.'.$tutup_kasExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_tutup_kas_tmp, 'file/register_kas/'.$nama_tutup_kas_baru)){
      // Query untuk menampilkan data tutup_kas berdasarkan id_tutup_kas yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_tutup_kas WHERE id_tutup_kas='".$id_tutup_kas."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/register_kas/".$data['tutup_kas'])) // Jika file ada
        unlink("file/register_kas/".$data['tutup_kas']); // Hapus file sebelumnya yang ada di folder tutup_kas
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_tutup_kas SET  tutup_kas='$nama_tutup_kas_baru',validasi='$validasi',catatan='$catatan' WHERE id_tutup_kas='$id_tutup_kas'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=register_kas");

}
?>