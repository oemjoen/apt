<?php
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_tanggal.php";
date_default_timezone_set('Asia/Jakarta'); 

$table		="mstproduk";

$kodeproduk				=$_POST[kodeproduk];
$nama_barang			=str_replace("'","\'",$_POST[nama_barang]);
$satuan					=$_POST[satuan];
$text_isi_satuan		=$_POST[text_isi_satuan];
$text_berat_satuan		=$_POST[text_berat_satuan];
$text_prinsipal			=$_POST[text_prinsipal];
$text_supplier			=$_POST[text_supplier];
$text_kat_khusus		=$_POST[text_kat_khusus];
$textcabang				=$_POST[textcabang];
$textusername			=$_POST[textusername];
$textkandungan			=$_POST[textkandungan];
$textsediaan			=$_POST[textsediaan];
$tglbuat				= date("Y-m-d H:i:s");



$text = "SELECT `kodeproduk`,`namaproduk`,`kodeprinsipal`,`kategorikhusus`,
			  `kodesupplier`,`satuan`,`isisatuan`,`beratsatuan`,
			  `date_add`,`date_edit`,`user_add`,`user_edit`
				   FROM $table 
				   WHERE kodeproduk= '$kodeproduk'";
$sql = mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table 
						SET 
						  `namaproduk` = UPPER('$nama_barang'),
						  `kodeprinsipal` = UPPER('$text_prinsipal'),
						  `kategorikhusus` = UPPER('$text_kat_khusus'),
						  `kodesupplier` = UPPER('$text_supplier'),
						  `satuan` = UPPER('$satuan'),
						  `isisatuan` = '$text_isi_satuan',
						  `beratsatuan` = '$text_berat_satuan',
						  `kandungan` = '$textkandungan',
						  `sediaan` = '$textsediaan',
						  `date_edit` = '$tglbuat',
						  `user_edit` = '$textusername'
						WHERE `kodeproduk` = '$kodeproduk'";
	mysql_query($input);								
	echo "<label id='info'><b>Data Sukses diubah</b></label>";
}else{
	$input = "INSERT INTO $table 
            (`kodeproduk`,
             `namaproduk`,
             `kodeprinsipal`,
             `kategorikhusus`,
             `kodesupplier`,
             `satuan`,
             `isisatuan`,
             `beratsatuan`,
             `kandungan`,
             `sediaan`,
             `date_add`,
             `user_add`)
VALUES (UPPER('$kodeproduk'),
        UPPER('$nama_barang'),
        UPPER('$text_prinsipal'),
        UPPER('$text_kat_khusus'),
        UPPER('$text_supplier'),
        UPPER('$satuan'),
        '$text_isi_satuan',
        '$text_berat_satuan',
        UPPER('$textkandungan'),
        UPPER('$textsediaan'),
        '$tglbuat',
        '$textusername')";
	mysql_query($input);
	echo "<label id='info'><b>Data sukses disimpan</b></label>";
}	
//echo "<br/>".$input."<br/>".$text;
include "tampil_data.php";

?>