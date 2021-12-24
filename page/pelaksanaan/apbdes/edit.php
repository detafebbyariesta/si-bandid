<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_realisasi_apbdes = $_POST['id_realisasi_apbdes'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $realisasi_apbdes = $_FILES['realisasi_apbdes']['name'];
  $fotoapbdes1 = $_FILES['fotoapbdes1']['name'];
  $fotoapbdes2 = $_FILES['fotoapbdes2']['name'];
  $fotoapbdes3 = $_FILES['fotoapbdes3']['name'];
  $fotoapbdes4 = $_FILES['fotoapbdes4']['name'];

//cek dulu jika file jalankan coding ini
  if($realisasi_apbdes != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $realisasi_apbdes); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_realisasi_apbdes_tmp = $_FILES['realisasi_apbdes']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $realisasi_apbdesExt = substr($realisasi_apbdes, strrpos($realisasi_apbdes, '.')); 
    $realisasi_apbdesExt = str_replace('.','',$realisasi_apbdesExt); // Extension
    $realisasi_apbdes = preg_replace("/\.[^.\s]{3,4}$/", "", $realisasi_apbdes); 
    $nama_realisasi_apbdes_baru = "APBDES_".$acak.'.'.$realisasi_apbdesExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_realisasi_apbdes_tmp, 'file/apbdes/'.$nama_realisasi_apbdes_baru)){
      // Query untuk menampilkan data realisasi_dd berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_apbdes WHERE id_realisasi_apbdes='".$id_realisasi_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/apbdes/".$data['realisasi_apbdes'])) // Jika file ada
        unlink("file/apbdes/".$data['realisasi_apbdes']); // Hapus file sebelumnya yang ada di folder realisasi_dd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_apbdes SET  realisasi_apbdes='$nama_realisasi_apbdes_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_apbdes='$id_realisasi_apbdes'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoapbdes1 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoapbdes1); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoapbdes1_tmp = $_FILES['fotoapbdes1']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoapbdes1Ext = substr($fotoapbdes1, strrpos($fotoapbdes1, '.')); 
    $fotoapbdes1Ext = str_replace('.','',$fotoapbdes1Ext); // Extension
    $fotoapbdes1 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoapbdes1);  
    $nama_fotoapbdes1_baru = "foto1_".$acak.'.'.$fotoapbdes1Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoapbdes1_tmp, 'file/foto/foto1/'.$nama_fotoapbdes1_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_apbdes WHERE id_realisasi_apbdes='".$id_realisasi_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto1/".$data['foto_apbdes_1'])) // Jika file ada
        unlink("file/foto/foto1/".$data['foto_apbdes_1']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_apbdes SET foto_apbdes_1='$nama_fotoapbdes1_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_apbdes='$id_realisasi_apbdes'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoapbdes2 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoapbdes2); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoapbdes2_tmp = $_FILES['fotoapbdes2']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoapbdes2Ext = substr($fotoapbdes2, strrpos($fotoapbdes2, '.')); 
    $fotoapbdes2Ext = str_replace('.','',$fotoapbdes2Ext); // Extension
    $fotoapbdes2 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoapbdes2);  
    $nama_fotoapbdes2_baru = "foto2_".$acak.'.'.$fotoapbdes2Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoapbdes2_tmp, 'file/foto/foto2/'.$nama_fotoapbdes2_baru)){
      // Query untuk menampilkan data fotodd2 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_apbdes WHERE id_realisasi_apbdes='".$id_realisasi_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto2/".$data['foto_apbdes_2'])) // Jika file ada
        unlink("file/foto/foto2/".$data['foto_apbdes_2']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_apbdes SET foto_apbdes_2='$nama_fotoapbdes2_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_apbdes='$id_realisasi_apbdes'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoapbdes3 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoapbdes3); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoapbdes3_tmp = $_FILES['fotoapbdes3']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoapbdes3Ext = substr($fotoapbdes3, strrpos($fotoapbdes3, '.')); 
    $fotoapbdes3Ext = str_replace('.','',$fotoapbdes3Ext); // Extension
    $fotoapbdes3 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoapbdes3);  
    $nama_fotoapbdes3_baru = "foto3_".$acak.'.'.$fotoapbdes3Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoapbdes3_tmp, 'file/foto/foto3/'.$nama_fotoapbdes3_baru)){
      // Query untuk menampilkan data fotodd3 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_apbdes WHERE id_realisasi_apbdes='".$id_realisasi_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto3/".$data['foto_apbdes_3'])) // Jika file ada
        unlink("file/foto/foto3/".$data['foto_apbdes_3']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_apbdes SET foto_apbdes_3='$nama_fotoapbdes3_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_apbdes='$id_realisasi_apbdes'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoapbdes4 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoapbdes4); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoapbdes4_tmp = $_FILES['fotoapbdes4']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoapbdes4Ext = substr($fotoapbdes4, strrpos($fotoapbdes4, '.')); 
    $fotoapbdes4Ext = str_replace('.','',$fotoapbdes4Ext); // Extension
    $fotoapbdes4 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoapbdes4);  
    $nama_fotoapbdes4_baru = "foto4_".$acak.'.'.$fotoapbdes4Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoapbdes4_tmp, 'file/foto/foto4/'.$nama_fotoapbdes4_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_apbdes WHERE id_realisasi_apbdes='".$id_realisasi_apbdes."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto4/".$data['foto_apbdes_4'])) // Jika file ada
        unlink("file/foto/foto4/".$data['foto_apbdes_4']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_apbdes SET foto_apbdes_4='$nama_fotoapbdes4_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_apbdes='$id_realisasi_apbdes'");
      }
    }
  }
        // Show message when user apbdesed
        header("Location:../../../index.php?page=p_apbdes");
}
?>