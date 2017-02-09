<?php
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_tanggal.php";
date_default_timezone_set('Asia/Bangkok');


$table		="po_pembelian";

$kodepo_beli		=$_POST[kodepo_beli];
$kode				=$_POST[kode];
//$tgl				=jin_date_sql($_POST[tgl]);
$tgl				=date('Y-m-d');
$jml				=$_POST[jml];
$kodeuser			=$_POST[kodeuser];
$jmlvalid			=$_POST[jmlvalid];
$kode_supplier		=$_POST[kode_supplier];
$kode_brg			=$_POST[kode_brg];
$cabang				=$_POST[cabang];
$ket_pusat			=$_POST[ket_pusat];
$ket_relokasi		="";
$jmlvalidrelokasi	=0;
$cabangrelokasi		="";
$prins				=$_POST[prins];
$tglbuat			=date('Y-m-d H:i:s');


$query ="SELECT kodepo_beli,tglpo_beli,kode_beli,kode_supplier,kode_barang,jumlah_beli,jumlah_beli_valid,cabang,ket_pusat
				   FROM $table 
				   WHERE kodepo_beli= '$kodepo_beli' and kode_beli= '$kode' and kode_barang='$kode_brg'";
$sql = mysql_query($query);
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET jumlah_beli_valid	='$jmlvalid', ket_pusat='$ket_pusat',kode_prinsipal='$prins',
				tgl_edit='$tglbuat',user_edit='$kodeuser',relokasi='$ket_relokasi',relokasi_jumlah_beli_valid='$jmlvalidrelokasi',
				relokasi_cabang='$cabangrelokasi'
					WHERE kodepo_beli= '$kodepo_beli' AND kode_beli= '$kode' AND tglpo_beli= '$tgl' AND kode_barang='$kode_brg' ";
	mysql_query($input);
		//echo $input."<br>";
		//echo $query."<br>";								
	echo "<label id='info'><b>Data Sukses diubah</b></label>";
}else{
	$input = "INSERT INTO $table (kodepo_beli,tglpo_beli,kode_beli,kode_prinsipal,kode_supplier,kode_barang,jumlah_beli,jumlah_beli_valid,cabang,ket_pusat,tgl_buat,user_buat,relokasi,relokasi_jumlah_beli_valid,relokasi_cabang)
				VALUES('$kodepo_beli','$tgl','$kode','$prins','$kode_supplier','$kode_brg','$jml','$jmlvalid','$cabang','$ket_pusat','$tglbuat','$kodeuser','$ket_relokasi','$jmlvalidrelokasi','$cabangrelokasi')";
	mysql_query($input);
		//echo $input."<br>";
		//echo $query."<br>";
	echo "<label id='info'><b>Data sukses disimpan</b></label>";
}	
//echo $query."<br>".$input."<br/>";
//include "tampil_data.php";

?>