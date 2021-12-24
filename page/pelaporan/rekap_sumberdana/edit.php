<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_realisasi_apbdes_dana = $_POST['id_realisasi_apbdes_dana'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$realisasi_apbdes_dana = $_FILES['realisasi_apbdes_dana']['name'];

//cek dulu jika file jalankan coding ini
  if($realisasi_apbdes_dana != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $realisasi_apbdes_dana); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_realisasi_apbdes_dana_tmp = $_FILES['realisasi_apbdes_dana']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $realisasi_apbdes_danaExt = substr($realisasi_apbdes_dana, strrpos($realisasi_apbdes_dana, '.')); 
    $realisasi_apbdes_danaExt = str_replace('.','',$realisasi_apbdes_danaExt); // Extension
    $realisasi_apbdes_dana = preg_replace("/\.[^.\s]{3,4}$/", "", $realisasi_apbdes_dana); 
    $nama_realisasi_apbdes_dana_baru = "rekap_sumberdana_".$acak.'.'.$realisasi_apbdes_danaExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_realisasi_apbdes_dana_tmp, 'file/rekap_sumberdana/'.$nama_realisasi_apbdes_dana_baru)){
      // Query untuk menampilkan data realisasi_apbdes_dana berdasarkan id_realisasi_apbdes_dana yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_apbdes_dana WHERE id_realisasi_apbdes_dana='".$id_realisasi_apbdes_dana."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/rekap_sumberdana/".$data['realisasi_apbdes_dana'])) // Jika file ada
        unlink("file/rekap_sumberdana/".$data['realisasi_apbdes_dana']); // Hapus file sebelumnya yang ada di folder realisasi_apbdes_dana
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_apbdes_dana SET  realisasi_apbdes_dana='$nama_realisasi_apbdes_dana_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_apbdes_dana='$id_realisasi_apbdes_dana'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=rekap_sumberdana");

}
?>