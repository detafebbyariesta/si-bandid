<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_realisasi_pad = $_POST['id_realisasi_pad'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $realisasi_pad = $_FILES['realisasi_pad']['name'];
  $fotopad1 = $_FILES['fotopad1']['name'];
  $fotopad2 = $_FILES['fotopad2']['name'];
  $fotopad3 = $_FILES['fotopad3']['name'];
  $fotopad4 = $_FILES['fotopad4']['name'];

//cek dulu jika file jalankan coding ini
  if($realisasi_pad != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $realisasi_pad); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_realisasi_pad_tmp = $_FILES['realisasi_pad']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $realisasi_padExt = substr($realisasi_pad, strrpos($realisasi_pad, '.')); 
    $realisasi_padExt = str_replace('.','',$realisasi_padExt); // Extension
    $realisasi_pad = preg_replace("/\.[^.\s]{3,4}$/", "", $realisasi_pad); 
    $nama_realisasi_pad_baru = "PAD_".$acak.'.'.$realisasi_padExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_realisasi_pad_tmp, 'file/pad/'.$nama_realisasi_pad_baru)){
      // Query untuk menampilkan data realisasi_dd berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_pad WHERE id_realisasi_pad='".$id_realisasi_pad."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/pad/".$data['realisasi_pad'])) // Jika file ada
        unlink("file/pad/".$data['realisasi_pad']); // Hapus file sebelumnya yang ada di folder realisasi_dd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_pad SET  realisasi_pad='$nama_realisasi_pad_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_pad='$id_realisasi_pad'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotopad1 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotopad1); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotopad1_tmp = $_FILES['fotopad1']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotopad1Ext = substr($fotopad1, strrpos($fotopad1, '.')); 
    $fotopad1Ext = str_replace('.','',$fotopad1Ext); // Extension
    $fotopad1 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotopad1);  
    $nama_fotopad1_baru = "foto1_".$acak.'.'.$fotopad1Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotopad1_tmp, 'file/foto/foto1/'.$nama_fotopad1_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_pad WHERE id_realisasi_pad='".$id_realisasi_pad."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto1/".$data['foto_pad_1'])) // Jika file ada
        unlink("file/foto/foto1/".$data['foto_pad_1']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_pad SET foto_pad_1='$nama_fotopad1_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_pad='$id_realisasi_pad'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotopad2 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotopad2); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotopad2_tmp = $_FILES['fotopad2']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotopad2Ext = substr($fotopad2, strrpos($fotopad2, '.')); 
    $fotopad2Ext = str_replace('.','',$fotopad2Ext); // Extension
    $fotopad2 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotopad2);  
    $nama_fotopad2_baru = "foto2_".$acak.'.'.$fotopad2Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotopad2_tmp, 'file/foto/foto2/'.$nama_fotopad2_baru)){
      // Query untuk menampilkan data fotodd2 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_pad WHERE id_realisasi_pad='".$id_realisasi_pad."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto2/".$data['foto_pad_2'])) // Jika file ada
        unlink("file/foto/foto2/".$data['foto_pad_2']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_pad SET foto_pad_2='$nama_fotopad2_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_pad='$id_realisasi_pad'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotopad3 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotopad3); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotopad3_tmp = $_FILES['fotopad3']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotopad3Ext = substr($fotopad3, strrpos($fotopad3, '.')); 
    $fotopad3Ext = str_replace('.','',$fotopad3Ext); // Extension
    $fotopad3 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotopad3);  
    $nama_fotopad3_baru = "foto3_".$acak.'.'.$fotopad3Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotopad3_tmp, 'file/foto/foto3/'.$nama_fotopad3_baru)){
      // Query untuk menampilkan data fotodd3 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_pad WHERE id_realisasi_pad='".$id_realisasi_pad."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto3/".$data['foto_pad_3'])) // Jika file ada
        unlink("file/foto/foto3/".$data['foto_pad_3']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_pad SET foto_pad_3='$nama_fotopad3_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_pad='$id_realisasi_pad'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotopad4 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotopad4); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotopad4_tmp = $_FILES['fotopad4']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotopad4Ext = substr($fotopad4, strrpos($fotopad4, '.')); 
    $fotopad4Ext = str_replace('.','',$fotopad4Ext); // Extension
    $fotopad4 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotopad4);  
    $nama_fotopad4_baru = "foto4_".$acak.'.'.$fotopad4Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotopad4_tmp, 'file/foto/foto4/'.$nama_fotopad4_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_pad WHERE id_realisasi_pad='".$id_realisasi_pad."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto4/".$data['foto_pad_4'])) // Jika file ada
        unlink("file/foto/foto4/".$data['foto_pad_4']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_pad SET foto_pad_4='$nama_fotopad4_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_pad='$id_realisasi_pad'");
      }
    }
  }
        // Show message when user paded
        header("Location:../../../index.php?page=p_pad");
}
?>