<?php
include "../../inc/inc.koneksi.php";
$kode	= $_POST['kode'];
$text	= "SELECT *
			FROM mstproduk WHERE namaproduk= '$kode'";
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
while ($r=mysql_fetch_array($sql)){	
	
	$data['kodeproduk']				= $r[kodeproduk];
	$data['nama_barang']			= $r[namaproduk];
	$data['satuan']					= $r[satuan];
	$data['text_isi_satuan']		= $r[isisatuan];
	$data['text_berat_satuan']		= $r[beratsatuan];
	$data['text_prinsipal']			= $r[kodeprinsipal];
	$data['text_supplier']			= $r[kodesupplier];
	$data['text_kat_khusus']		= $r[kategorikhusus];
	$data['text_kandungan']			= $r[kandungan];
	$data['text_sediaan']			= $r[sediaan];
	
	echo json_encode($data);
}
}else{

	$data['kodeproduk']				= '';
	$data['nama_barang']			= '';
	$data['satuan']					= '';
	$data['text_isi_satuan']		= '';
	$data['text_berat_satuan']		= '';
	$data['text_prinsipal']			= '';
	$data['text_supplier']			= '';
	$data['text_kat_khusus']		= '';
	$data['text_kandungan']			= '';
	$data['text_sediaan']			= '';
	
	echo json_encode($data);
	
}

?>