<?php
$koneksi = mysqli_connect ("localhost","root","",
"db_sibandid"
			);
if (mysqli_connect_errno())
	{
		echo "Koneksi Gagal"
		.mysqli_connect_error();
	}
?>
