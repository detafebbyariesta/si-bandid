<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_tanggung_jawab = $_POST['id_tanggung_jawab'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $tanggung_jawab = $_FILES['tanggung_jawab']['name'];
  $perdes = $_FILES['perdes']['name'];

//cek dulu jika file jalankan coding ini
  if($tanggung_jawab != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $tanggung_jawab); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_tanggung_jawab_tmp = $_FILES['tanggung_jawab']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $tanggung_jawabExt = substr($tanggung_jawab, strrpos($tanggung_jawab, '.')); 
    $tanggung_jawabExt = str_replace('.','',$tanggung_jawabExt); // Extension
    $tanggung_jawab = preg_replace("/\.[^.\s]{3,4}$/", "", $tanggung_jawab); 
    $nama_tanggung_jawab_baru = "Tanggung_jawab_".$acak.'.'.$tanggung_jawabExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_tanggung_jawab_tmp, 'file/tanggungjawab/'.$nama_tanggung_jawab_baru)){
      // Query untuk menampilkan data tanggung_jawab berdasarkan id_tanggung_jawab yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_tanggung_jawab WHERE id_tanggung_jawab='".$id_tanggung_jawab."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/tanggungjawab/".$data['tanggung_jawab'])) // Jika file ada
        unlink("file/tanggungjawab/".$data['tanggung_jawab']); // Hapus file sebelumnya yang ada di folder tanggung_jawab
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_tanggung_jawab SET  tanggung_jawab='$nama_tanggung_jawab_baru',validasi='$validasi',catatan='$catatan' WHERE id_tanggung_jawab='$id_tanggung_jawab'");
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
      // Query untuk menampilkan data perdes berdasarkan id_tanggung_jawab yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_tanggung_jawab WHERE id_tanggung_jawab='".$id_tanggung_jawab."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/perdes/".$data['perdes'])) // Jika file ada
        unlink("file/perdes/".$data['perdes']); // Hapus file sebelumnya yang ada di folder perdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_tanggung_jawab SET perdes='$nama_perdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_tanggung_jawab='$id_tanggung_jawab'");
      }
    }
  }
        // Show message when user added
        header("Location:../../../index.php?page=tanggungjawab");
}
?>