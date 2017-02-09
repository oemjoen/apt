<?php
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_tanggal.php";

$tgl	= jin_date_sql($_POST["tgl"]);
$ap = $_POST["ap"];

$sql	= mysql_query("SELECT DISTINCT NoDIH FROM t_dih WHERE kodeApotik='$ap' AND STATUS ='OpenDIH'");
while($r=mysql_fetch_array($sql)){
	$kode = $r['NoDIH'];
	echo "<option value='$kode'>$kode</option>";
}
?>