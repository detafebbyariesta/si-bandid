<?php 
// memanggil file koneksi.php untuk melakukan koneksi database
include '../../../asset/inc/config.php';

if (isset($_POST['update'])) 
{
	$id_ba_kas = $_POST['id_ba_kas'];
  $validasi = $_POST['validasi'];
  $catatan = $_POST['catatan'];
  $bulan = $_POST['bulan'];
	$ba_kas = $_FILES['ba_kas']['name'];

  // var_dump($id_ba_kas);
  // var_dump($validasi);
  // var_dump($catatan);
  // var_dump($bulan);
  // var_dump($ba_kas);

//cek dulu jika file jalankan coding ini
  if($ba_kas != "") {
    $ekstensi_diperbolehkan = array('xlsx','xls','doc','docx','pdf'); //ekstensi file gambar yang bisa diupload 
    $x = explode('.', $ba_kas); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_ba_kas_tmp = $_FILES['ba_kas']['tmp_name'];   
    $acak = rand(00000000, 99999999);
    $ba_kasExt = substr($ba_kas, strrpos($ba_kas, '.')); 
    $ba_kasExt = str_replace('.','',$ba_kasExt); // Extension
    $ba_kas = preg_replace("/\.[^.\s]{3,4}$/", "", $ba_kas); 
    $nama_ba_kas_baru = "ba_kas_".$acak.'.'.$ba_kasExt;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
      if (move_uploaded_file($file_ba_kas_tmp, 'file/ba_kas/'.$nama_ba_kas_baru)){
      // Query untuk menampilkan data ba_kas berdasarkan id_ba_kas yang dikirim
      $sqlcek = mysqli_query($koneksi, "SELECT * FROM tb_ba_kas WHERE id_ba_kas='".$id_ba_kas."'");
      $data = mysqli_fetch_array($sqlcek); // Ambil data dari hasil eksekusi $sqlcek
      // Cek apakah file sebelumnya ada di folder
      if(is_file("file/ba_kas/".$data['ba_kas'])) // Jika file ada
        unlink("file/ba_kas/".$data['ba_kas']); // Hapus file sebelumnya yang ada di folder ba_kas
      // Insert file into table
        $result = mysqli_query($koneksi, "UPDATE tb_ba_kas SET ba_kas='$nama_ba_kas_baru',validasi='$validasi',catatan='$catatan',bulan='$bulan' WHERE id_ba_kas='$id_ba_kas'");
      }
    }
  }

        // Show message when user added
        header("Location:../../../index.php?page=ba_kas");

}
?>