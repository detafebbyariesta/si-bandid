<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_rekap_realisasi_apbdes = $_POST['id_rekap_realisasi_apbdes'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
	$rekap_realisasi_apbdes = $_FILES['rekap_realisasi_apbdes']['name'];

//cek dulu jika file jalankan coding ini
  if($rekap_realisasi_apbdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $rekap_realisasi_apbdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_rekap_realisasi_apbdes_tmp = $_FILES['rekap_realisasi_apbdes']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $rekap_realisasi_apbdesExt = substr($rekap_realisasi_apbdes, strrpos($rekap_realisasi_apbdes, '.')); 
    $rekap_realisasi_apbdesExt = str_replace('.','',$rekap_realisasi_apbdesExt); // Extension
    $rekap_realisasi_apbdes = preg_replace("/\.[^.\s]{3,4}$/", "", $rekap_realisasi_apbdes); 
    $nama_rekap_realisasi_apbdes_baru = "rekap_apbdes_".$acak.'.'.$rekap_realisasi_apbdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_rekap_realisasi_apbdes_tmp, 'file/rekap_apbdes/'.$nama_rekap_realisasi_apbdes_baru)){
      // Query untuk menampilkan data rekap_realisasi_apbdes berdasarkan id_rekap_realisasi_apbdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_rekap_realisasi_apbdes WHERE id_rekap_realisasi_apbdes='".$id_rekap_realisasi_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/rekap_apbdes/".$data['rekap_realisasi_apbdes'])) // Jika file ada
        unlink("file/rekap_apbdes/".$data['rekap_realisasi_apbdes']); // Hapus file sebelumnya yang ada di folder rekap_realisasi_apbdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_rekap_realisasi_apbdes SET  rekap_realisasi_apbdes='$nama_rekap_realisasi_apbdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_rekap_realisasi_apbdes='$id_rekap_realisasi_apbdes'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=rekap_apbdes");

}
?>