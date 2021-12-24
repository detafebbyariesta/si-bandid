<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_apbdes = $_POST['id_apbdes'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $apbdes = $_FILES['apbdes']['name'];
  $perdes = $_FILES['perdes']['name'];
  $perkades = $_FILES['perkades']['name'];

//cek dulu jika file jalankan coding ini
  if($apbdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $apbdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_apbdes_tmp = $_FILES['apbdes']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $apbdesExt = substr($apbdes, strrpos($apbdes, '.')); 
    $apbdesExt = str_replace('.','',$apbdesExt); // Extension
    $apbdes = preg_replace("/\.[^.\s]{3,4}$/", "", $apbdes); 
    $nama_apbdes_baru = "APBDes_".$acak.'.'.$apbdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_apbdes_tmp, 'file/apbdes/'.$nama_apbdes_baru)){
      // Query untuk menampilkan data apbdes berdasarkan id_apbdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_apbdes WHERE id_apbdes='".$id_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/apbdes/".$data['apbdes'])) // Jika file ada
        unlink("file/apbdes/".$data['apbdes']); // Hapus file sebelumnya yang ada di folder apbdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_apbdes SET  apbdes='$nama_apbdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_apbdes='$id_apbdes'");
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
      // Query untuk menampilkan data perdes berdasarkan id_apbdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_apbdes WHERE id_apbdes='".$id_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/perdes/".$data['perdes'])) // Jika file ada
        unlink("file/perdes/".$data['perdes']); // Hapus file sebelumnya yang ada di folder perdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_apbdes SET perdes='$nama_perdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_apbdes='$id_apbdes'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($perkades != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $perkades); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_perkades_tmp = $_FILES['perkades']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $perkadesExt = substr($perkades, strrpos($perkades, '.')); 
    $perkadesExt = str_replace('.','',$perkadesExt); // Extension
    $perkades = preg_replace("/\.[^.\s]{3,4}$/", "", $perkades);  
    $nama_perkades_baru = "PERKADes_".$acak.'.'.$perkadesExt; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_perkades_tmp, 'file/perkades/'.$nama_perkades_baru)){
      // Query untuk menampilkan data perkades berdasarkan id_apbdes yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_apbdes WHERE id_apbdes='".$id_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/perkades/".$data['perkades'])) // Jika file ada
        unlink("file/perkades/".$data['perkades']); // Hapus file sebelumnya yang ada di folder perdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_apbdes SET perkades='$nama_perkades_baru',validasi='$validasi',catatan='$catatan' WHERE id_apbdes='$id_apbdes'");
      }
    }
  }
        // Show message when user added
        header("Location:../../../index.php?page=apbdes");
}
?>