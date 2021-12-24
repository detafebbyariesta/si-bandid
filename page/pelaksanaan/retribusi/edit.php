<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_retribusi = $_POST['id_retribusi'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $keterangan = $_POST['keterangan'];
  $retribusi = $_FILES['retribusi']['name'];
  $fotoretribusi1 = $_FILES['fotoretribusi1']['name'];
  $fotoretribusi2 = $_FILES['fotoretribusi2']['name'];
  $fotoretribusi3 = $_FILES['fotoretribusi3']['name'];
  $fotoretribusi4 = $_FILES['fotoretribusi4']['name'];

  // var_dump($retribusi);
  // var_dump($keterangan);
  // var_dump($fotoretribusi1);

//cek dulu jika file jalankan coding ini
  if($retribusi != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $retribusi); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_retribusi_tmp = $_FILES['retribusi']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $retribusiExt = substr($retribusi, strrpos($retribusi, '.')); 
    $retribusiExt = str_replace('.','',$retribusiExt); // Extension
    $retribusi = preg_replace("/\.[^.\s]{3,4}$/", "", $retribusi); 
    $nama_retribusi_baru = "Retribusi_".$acak.'.'.$retribusiExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_retribusi_tmp, 'file/retribusi/'.$nama_retribusi_baru)){
      // Query untuk menampilkan data
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_retribusi WHERE id_retribusi='".$id_retribusi."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/retribusi/".$data['retribusi'])) // Jika file ada
        unlink("file/retribusi/".$data['retribusi']); // Hapus file sebelumnya yang ada di folder realisasi_dd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_retribusi SET retribusi='$nama_retribusi_baru',validasi='$validasi',catatan='$catatan' WHERE id_retribusi='$id_retribusi'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoretribusi1 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoretribusi1); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoretribusi1_tmp = $_FILES['fotoretribusi1']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoretribusi1Ext = substr($fotoretribusi1, strrpos($fotoretribusi1, '.')); 
    $fotoretribusi1Ext = str_replace('.','',$fotoretribusi1Ext); // Extension
    $fotoretribusi1 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoretribusi1);  
    $nama_fotoretribusi1_baru = "foto1_".$acak.'.'.$fotoretribusi1Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoretribusi1_tmp, 'file/foto/foto1/'.$nama_fotoretribusi1_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_retribusi WHERE id_retribusi='".$id_retribusi."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto1/".$data['foto1'])) // Jika file ada
        unlink("file/foto/foto1/".$data['foto1']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_retribusi SET foto1='$nama_fotoretribusi1_baru',validasi='$validasi',catatan='$catatan' WHERE id_retribusi='$id_retribusi'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoretribusi2 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoretribusi2); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoretribusi2_tmp = $_FILES['fotoretribusi2']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoretribusi2Ext = substr($fotoretribusi2, strrpos($fotoretribusi2, '.')); 
    $fotoretribusi2Ext = str_replace('.','',$fotoretribusi2Ext); // Extension
    $fotoretribusi2 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoretribusi2);  
    $nama_fotoretribusi2_baru = "foto2_".$acak.'.'.$fotoretribusi2Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoretribusi2_tmp, 'file/foto/foto2/'.$nama_fotoretribusi2_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_retribusi WHERE id_retribusi='".$id_retribusi."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto2/".$data['foto2'])) // Jika file ada
        unlink("file/foto/foto2/".$data['foto2']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_retribusi SET foto2='$nama_fotoretribusi2_baru',validasi='$validasi',catatan='$catatan',keterangan='$keterangan' WHERE id_retribusi='$id_retribusi'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
   if($fotoretribusi3 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoretribusi3); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoretribusi3_tmp = $_FILES['fotoretribusi3']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoretribusi3Ext = substr($fotoretribusi3, strrpos($fotoretribusi3, '.')); 
    $fotoretribusi3Ext = str_replace('.','',$fotoretribusi3Ext); // Extension
    $fotoretribusi3 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoretribusi3);  
    $nama_fotoretribusi3_baru = "foto3_".$acak.'.'.$fotoretribusi3Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoretribusi3_tmp, 'file/foto/foto3/'.$nama_fotoretribusi3_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_retribusi WHERE id_retribusi='".$id_retribusi."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto3/".$data['foto3'])) // Jika file ada
        unlink("file/foto/foto3/".$data['foto3']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_retribusi SET foto3='$nama_fotoretribusi3_baru',validasi='$validasi',catatan='$catatan',keterangan='$keterangan' WHERE id_retribusi='$id_retribusi'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
   if($fotoretribusi4 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoretribusi4); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoretribusi4_tmp = $_FILES['fotoretribusi4']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoretribusi4Ext = substr($fotoretribusi4, strrpos($fotoretribusi4, '.')); 
    $fotoretribusi4Ext = str_replace('.','',$fotoretribusi4Ext); // Extension
    $fotoretribusi4 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoretribusi4);  
    $nama_fotoretribusi4_baru = "foto4_".$acak.'.'.$fotoretribusi4Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoretribusi4_tmp, 'file/foto/foto4/'.$nama_fotoretribusi4_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_retribusi WHERE id_retribusi='".$id_retribusi."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto4/".$data['foto4'])) // Jika file ada
        unlink("file/foto/foto4/".$data['foto4']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_retribusi SET foto4='$nama_fotoretribusi4_baru',validasi='$validasi',catatan='$catatan',keterangan='$keterangan' WHERE id_retribusi='$id_retribusi'");
      }
    }
  }

  if ($keterangan != "") {
    $result = mysqli_query($koneksi, "UPDATE tb_retribusi SET validasi='$validasi',catatan='$catatan',keterangan='$keterangan' WHERE id_retribusi='$id_retribusi'");
  }
        // Show message when user retribusied
        header("Location:../../../index.php?page=retribusi");
}
?>