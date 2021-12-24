<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_bulanan = $_POST['id_bulanan'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $bulan = $_POST['bulan'];
	$bulanan = $_FILES['bulanan']['name'];

  // var_dump($id_bulanan);
  // var_dump($validasi);
  // var_dump($catatan);
  // var_dump($bulan);
  // var_dump($bulanan);

//cek dulu jika file jalankan coding ini
  if($bulanan != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $bulanan); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_bulanan_tmp = $_FILES['bulanan']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $bulananExt = substr($bulanan, strrpos($bulanan, '.')); 
    $bulananExt = str_replace('.','',$bulananExt); // Extension
    $bulanan = preg_replace("/\.[^.\s]{3,4}$/", "", $bulanan); 
    $nama_bulanan_baru = "Bulanan_".$acak.'.'.$bulananExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_bulanan_tmp, 'file/bulanan/'.$nama_bulanan_baru)){
      // Query untuk menampilkan data bulanan berdasarkan id_bulanan yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_bulanan WHERE id_bulanan='".$id_bulanan."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/bulanan/".$data['bulanan'])) // Jika file ada
        unlink("file/bulanan/".$data['bulanan']); // Hapus file sebelumnya yang ada di folder bulanan
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_bulanan SET bulanan='$nama_bulanan_baru',validasi='$validasi',catatan='$catatan',bulan='$bulan' WHERE id_bulanan='$id_bulanan'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=bulanan");

}
?>