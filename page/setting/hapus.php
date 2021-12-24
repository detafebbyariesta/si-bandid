<?php
include "../../asset/inc/config.php";
$id_user = mysqli_real_escape_string($koneksi,$_GET['id_user']);
$query = mysqli_query($koneksi,"DELETE FROM tb_user WHERE id_user='$id_user' ");
header('location:../../index.php?page=user');
?>