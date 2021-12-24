<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_apbdes_perub = $_POST['id_apbdes_perub'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $apbdes_perub = $_FILES['apbdes_perub']['name'];
  $perdes = $_FILES['perdes']['name'];
  $perkades = $_FILES['perkades']['name'];

//cek dulu jika file jalankan coding ini
  if($apbdes_perub != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $apbdes_perub); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_apbdes_perub_tmp = $_FILES['apbdes_perub']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $apbdes_perubExt = substr($apbdes_perub, strrpos($apbdes_perub, '.')); 
    $apbdes_perubExt = str_replace('.','',$apbdes_perubExt); // Extension
    $apbdes_perub = preg_replace("/\.[^.\s]{3,4}$/", "", $apbdes_perub); 
    $nama_apbdes_perub_baru = "APBDes_Perub_".$acak.'.'.$apbdes_perubExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_apbdes_perub_tmp, 'file/apbdes_perub/'.$nama_apbdes_perub_baru)){
      // Query untuk menampilkan data apbdes_perub berdasarkan id_apbdes_perub yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_apbdes_perub WHERE id_apbdes_perub='".$id_apbdes_perub."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/apbdes_perub/".$data['apbdes_perub'])) // Jika file ada
        unlink("file/apbdes_perub/".$data['apbdes_perub']); // Hapus file sebelumnya yang ada di folder apbdes_perub
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_apbdes_perub SET  apbdes_perub='$nama_apbdes_perub_baru',validasi='$validasi',catatan='$catatan' WHERE id_apbdes_perub='$id_apbdes_perub'");
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
      // Query untuk menampilkan data perdes berdasarkan id_apbdes_perub yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_apbdes_perub WHERE id_apbdes_perub='".$id_apbdes_perub."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/perdes/".$data['perdes'])) // Jika file ada
        unlink("file/perdes/".$data['perdes']); // Hapus file sebelumnya yang ada di folder perdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_apbdes_perub SET perdes='$nama_perdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_apbdes_perub='$id_apbdes_perub'");
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
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_apbdes_perub WHERE id_apbdes_perub='".$id_apbdes_perub."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/perkades/".$data['perkades'])) // Jika file ada
        unlink("file/perkades/".$data['perkades']); // Hapus file sebelumnya yang ada di folder perdes
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_apbdes_perub SET perkades='$nama_perkades_baru',validasi='$validasi',catatan='$catatan' WHERE id_apbdes_perub='$id_apbdes_perub'");
      }
    }
  }
        // Show message when user added
        header("Location:../../../index.php?page=apbdes_perub");
}
?>