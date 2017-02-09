<?php
include "../../inc/fungsi_rupiah.php";
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_hdt.php";

$kode	= $_POST['koder'];
$cabang	= $_POST['cabang1'];

$query = "Select *,`Nama Faktur` as namafaktur,`Contact Person` AS kontak, `Limit Kredit` AS limitk 
			From mretail where Cabang='$cabang' AND Kode='$kode'";
$sql	= mysql_query($query);
//echo $query;
while($r=mysql_fetch_array($sql)){
		$data= $r[Kode].' - '.$r[namafaktur].'&#013;&#010;'.$r[Alamat].'&#013;&#010;Contact Person : '.$r[kontak]."&#013;&#010;Telp : ".$r[Telp]." - SMS Order : ".$r[smsP]."&#013;&#010;Limit : ".format_rupiah_koma($r[limitk])."&#013;&#010;Piutang : ".format_rupiah_koma($r[Saldo]);		
		echo $data;
}

?>