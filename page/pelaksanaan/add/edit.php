<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
  $id_realisasi_add = $_POST['id_realisasi_add'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $realisasi_add = $_FILES['realisasi_add']['name'];
  $fotoadd1 = $_FILES['fotoadd1']['name'];
  $fotoadd2 = $_FILES['fotoadd2']['name'];
  $fotoadd3 = $_FILES['fotoadd3']['name'];
  $fotoadd4 = $_FILES['fotoadd4']['name'];

  // var_dump($id_realisasi_add);
  // var_dump($validasi);
  // var_dump($catatan);
  // var_dump($realisasi_add);
  // var_dump($fotoadd1);
  // var_dump($fotoadd2);
  // var_dump($fotoadd3);
  // var_dump($fotoadd4);

//cek dulu jika file jalankan coding ini
  if($realisasi_add != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $realisasi_add); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_realisasi_add_tmp = $_FILES['realisasi_add']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $realisasi_addExt = substr($realisasi_add, strrpos($realisasi_add, '.')); 
    $realisasi_addExt = str_replace('.','',$realisasi_addExt); // Extension
    $realisasi_add = preg_replace("/\.[^.\s]{3,4}$/", "", $realisasi_add); 
    $nama_realisasi_add_baru = "ADD_".$acak.'.'.$realisasi_addExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_realisasi_add_tmp, 'file/add/'.$nama_realisasi_add_baru)){
      // Query untuk menampilkan data realisasi_dd berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_add WHERE id_realisasi_add='".$id_realisasi_add."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/add/".$data['realisasi_add'])) // Jika file ada
        unlink("file/add/".$data['realisasi_add']); // Hapus file sebelumnya yang ada di folder realisasi_dd
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_add SET  realisasi_add='$nama_realisasi_add_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_add='$id_realisasi_add'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoadd1 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoadd1); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoadd1_tmp = $_FILES['fotoadd1']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoadd1Ext = substr($fotoadd1, strrpos($fotoadd1, '.')); 
    $fotoadd1Ext = str_replace('.','',$fotoadd1Ext); // Extension
    $fotoadd1 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoadd1);  
    $nama_fotoadd1_baru = "foto1_".$acak.'.'.$fotoadd1Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoadd1_tmp, 'file/foto/foto1/'.$nama_fotoadd1_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_add WHERE id_realisasi_add='".$id_realisasi_add."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto1/".$data['foto_add_1'])) // Jika file ada
        unlink("file/foto/foto1/".$data['foto_add_1']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_add SET foto_add_1='$nama_fotoadd1_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_add='$id_realisasi_add'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoadd2 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoadd2); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoadd2_tmp = $_FILES['fotoadd2']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoadd2Ext = substr($fotoadd2, strrpos($fotoadd2, '.')); 
    $fotoadd2Ext = str_replace('.','',$fotoadd2Ext); // Extension
    $fotoadd2 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoadd2);  
    $nama_fotoadd2_baru = "foto2_".$acak.'.'.$fotoadd2Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoadd2_tmp, 'file/foto/foto2/'.$nama_fotoadd2_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_add WHERE id_realisasi_add='".$id_realisasi_add."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto2/".$data['foto_add_2'])) // Jika file ada
        unlink("file/foto/foto2/".$data['foto_add_2']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_add SET foto_add_2='$nama_fotoadd2_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_add='$id_realisasi_add'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoadd3 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoadd3); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoadd3_tmp = $_FILES['fotoadd3']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoadd3Ext = substr($fotoadd3, strrpos($fotoadd3, '.')); 
    $fotoadd3Ext = str_replace('.','',$fotoadd3Ext); // Extension
    $fotoadd3 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoadd3);  
    $nama_fotoadd3_baru = "foto3_".$acak.'.'.$fotoadd3Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoadd3_tmp, 'file/foto/foto3/'.$nama_fotoadd3_baru)){
      // Query untuk menampilkan data fotodd3 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_add WHERE id_realisasi_add='".$id_realisasi_add."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto3/".$data['foto_add_3'])) // Jika file ada
        unlink("file/foto/foto3/".$data['foto_add_3']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_add SET foto_add_3='$nama_fotoadd3_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_add='$id_realisasi_add'");
      }
    }
  }

  //cek dulu jika ada file jalankan coding ini
  if($fotoadd4 != "") {
    $ekstensi_diperbolehkan = array('jpg','jpeg','png'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $fotoadd4); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_fotoadd4_tmp = $_FILES['fotoadd4']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $fotoadd4Ext = substr($fotoadd4, strrpos($fotoadd4, '.')); 
    $fotoadd4Ext = str_replace('.','',$fotoadd4Ext); // Extension
    $fotoadd4 = preg_replace("/\.[^.\s]{3,4}$/", "", $fotoadd4);  
    $nama_fotoadd4_baru = "foto4_".$acak.'.'.$fotoadd4Ext; //menggabungkan angka acak dengan nama file sebenarnya
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_fotoadd4_tmp, 'file/foto/foto4/'.$nama_fotoadd4_baru)){
      // Query untuk menampilkan data fotodd1 berdasarkan id_realisasi_dd yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_realisasi_add WHERE id_realisasi_add='".$id_realisasi_add."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/foto/foto4/".$data['foto_add_4'])) // Jika file ada
        unlink("file/foto/foto4/".$data['foto_add_4']); // Hapus file sebelumnya yang ada di folder fotodd1
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_realisasi_add SET foto_add_4='$nama_fotoadd4_baru',validasi='$validasi',catatan='$catatan' WHERE id_realisasi_add='$id_realisasi_add'");
      }
    }
  }
        // Show message when user added
        header("Location:../../../index.php?page=p_add");
}
?>