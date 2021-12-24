<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_realisasi_dd = $_POST['id_realisasi_dd'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $realisasi_dd = $_FILES['realisasi_dd']['name'];
  $fotodd1 = $_FILES['fotodd1']['name'];
  $fotodd2 = $_FILES['fotodd2']['name'];
  $fotodd3 = $_FILES['fotodd3']['name'];
  $fotodd4 = $_FILES['fotodd4']['name'];

//cek dulu jika file jalankan coding ini
  if($realisasi_dd != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $realisasi_dd); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_realisasi_dd_tmp = $_FILES['realisasi_dd']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $realisasi_ddExt = substr($realisasi_dd, strrpos($realisasi_dd, '.')); 
    $realisasi_ddExt = str_replace('.','',$realisasi_ddExt); // Extension
    $realisasi_dd = preg_replace("/\.[^.\s]{3,4}$/", "", $realisasi_dd); 
    $nama_realisasi_dd_baru = "P_DD_".$acak.'.'.$realisasi_ddExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_realisasi_dd_tmp, 'file/p_dd/'.$nama_realisasi_dd_baru)){
      // Query untuk menampilkan data realisasi_dd berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_dd WHERE id_realisasi_dd='".$id_realisasi_dd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/p_dd/".$data['realisasi_dd'])) // Jika file ada
        unlink("file/p_dd/".$data['realisasi_dd']); // Hapus file sebelumnya yang ada di folder realisasi_dd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_dd SET  realisasi_dd='$nama_realisasi_dd_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_dd='$id_realisasi_dd'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotodd1 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotodd1); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotodd1_tmp = $_FILES['fotodd1']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotodd1Ext = substr($fotodd1, strrpos($fotodd1, '.')); 
    $fotodd1Ext = str_replace('.','',$fotodd1Ext); // Extension
    $fotodd1 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotodd1);  
    $nama_fotodd1_baru = "foto1_".$acak.'.'.$fotodd1Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotodd1_tmp, 'file/foto/foto1/'.$nama_fotodd1_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_dd WHERE id_realisasi_dd='".$id_realisasi_dd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto1/".$data['foto_dd_1'])) // Jika file ada
        unlink("file/foto/foto1/".$data['foto_dd_1']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_dd SET foto_dd_1='$nama_fotodd1_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_dd='$id_realisasi_dd'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotodd2 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotodd2); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotodd2_tmp = $_FILES['fotodd2']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotodd2Ext = substr($fotodd2, strrpos($fotodd2, '.')); 
    $fotodd2Ext = str_replace('.','',$fotodd2Ext); // Extension
    $fotodd2 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotodd2);  
    $nama_fotodd2_baru = "foto2_".$acak.'.'.$fotodd2Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotodd2_tmp, 'file/foto/foto2/'.$nama_fotodd2_baru)){
      // Query untuk menampilkan data fotodd2 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_dd WHERE id_realisasi_dd='".$id_realisasi_dd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto2/".$data['foto_dd_2'])) // Jika file ada
        unlink("file/foto/foto2/".$data['foto_dd_2']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_dd SET foto_dd_2='$nama_fotodd2_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_dd='$id_realisasi_dd'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotodd3 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotodd3); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotodd3_tmp = $_FILES['fotodd3']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotodd3Ext = substr($fotodd3, strrpos($fotodd3, '.')); 
    $fotodd3Ext = str_replace('.','',$fotodd3Ext); // Extension
    $fotodd3 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotodd3);  
    $nama_fotodd3_baru = "foto3_".$acak.'.'.$fotodd3Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotodd3_tmp, 'file/foto/foto3/'.$nama_fotodd3_baru)){
      // Query untuk menampilkan data fotodd3 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_dd WHERE id_realisasi_dd='".$id_realisasi_dd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto3/".$data['foto_dd_3'])) // Jika file ada
        unlink("file/foto/foto3/".$data['foto_dd_3']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_dd SET foto_dd_3='$nama_fotodd3_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_dd='$id_realisasi_dd'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotodd4 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotodd4); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotodd4_tmp = $_FILES['fotodd4']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotodd4Ext = substr($fotodd4, strrpos($fotodd4, '.')); 
    $fotodd4Ext = str_replace('.','',$fotodd4Ext); // Extension
    $fotodd4 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotodd4);  
    $nama_fotodd4_baru = "foto4_".$acak.'.'.$fotodd4Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotodd4_tmp, 'file/foto/foto4/'.$nama_fotodd4_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_dd WHERE id_realisasi_dd='".$id_realisasi_dd."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto4/".$data['foto_dd_4'])) // Jika file ada
        unlink("file/foto/foto4/".$data['foto_dd_4']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_dd SET foto_dd_4='$nama_fotodd4_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_dd='$id_realisasi_dd'");
      }
    }
  }
        // Show message when user added
        header("Location:../../../index.php?page=p_dd");
}
?>