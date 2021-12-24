<?php 
session_start();

// menghubungkan php dengan koneksi database
include 'asset/inc/config.php';

if (isset($_POST['login'])) {
// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];
$tahun	  = $_POST['tahun'];
$_SESSION['tahun'] = $_POST['tahun'];
$query = "SELECT * from tb_user WHERE username='$username'";
  $result = mysqli_query($koneksi, $query);
  while($data = mysqli_fetch_assoc($result)){
	$_SESSION['id_user']	= $data['id_user'];
	$_SESSION['username']	= $data['username'];
	$_SESSION['nama_user']	= $data['nama_user'];
	$_SESSION['level']		= $data['level'];
    $hasil = $data["password"];
    $verf= password_verify($password, $hasil);
    if ($verf == true) {
		header("location:index.php");
	}else{
      echo "<script>
				alert('Login Failed. Username & password tidak sesuai...!');
				document.location='login.php';
			</script>";
    }
  }
}

?>