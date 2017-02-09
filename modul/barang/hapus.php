<?php
include "../../inc/inc.koneksi.php";

$kode	= $_POST['kodeproduk'];

$sql = mysql_query("SELECT * FROM mstproduk WHERE kodeproduk= '$kode'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input = "DELETE FROM mstproduk WHERE kodeproduk= '$kode'";
	mysql_query($input);
	echo "<label id='info'>Data sukses dihapus</label>";
}else{
	echo "<label id='info'>Maaf, tidak ada</label>";
}

include "tampil_data.php";
?>