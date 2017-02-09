<?php

include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_tanggal.php";
include "../../inc/fungsi_hdt.php";
date_default_timezone_set('Asia/Jakarta');


$table = "t_dih";

$NoDIH = $_POST[kode];
$Tgl_DIH = jin_date_sql($_POST[TglDIH]);
$NoOrder = $_POST[noOrder];
$Tgl_Order = jin_date_sql($_POST[tglF]);
$KodePenagih = $_POST[sls];
$Kodesls = $_POST[kdsls];
$KodePelanggan = $_POST[kpel];
$KodeApotik = $_POST[kap];
$Value = $_POST[tot];
$saldo = $_POST[sld];
$cabang = $_POST[cabang];
$username = $_POST[username];
$tglbuat = date("Y-m-d H:i:s");
$Umur = $Tgl_DIH - $Tgl_Order;


$sql = mysql_query("SELECT * FROM $table WHERE `NoDIH` = '$NoDIH' AND `KodeApotik` = '$KodeApotik' AND `KodePelanggan` = '$KodePelanggan' AND `NoOrder` = '$NoOrder'");
$sqlD = mysql_query("Update t_order set status='OpenDIH' where NoOrder='$NoOrder' AND `KodeApotik` = '$KodeApotik' AND `KodePelanggan` = '$KodePelanggan'");

$row = mysql_num_rows($sql);
if ($row > 0)
{
    $input = "UPDATE $table
                SET `NoOrder` = '$NoOrder',`Tgl_Order` = '$Tgl_Order',`Umur` = '$Umur',
                    `Value` = '$Value',`editdih` = '$tglbuat',`useredit` = '$username'
                WHERE `NoDIH` = '$NoDIH' AND `KodeApotik` = '$KodeApotik' AND `KodePelanggan` = '$KodePelanggan' 
                AND `NoOrder` = '$NoOrder' ;";

    mysql_query($input) or die(mysql_error());
    echo "<label id='info'><b>Data Sukses diubah</b></label>";
} else
{
    $input = "INSERT INTO $table
            (`NoDIH`,`Tgl_DIH`,`KodeApotik`,`KodePelanggan`,`KodePenagih`,`KodeSalesman`,`NoOrder`,`Tgl_Order`,`Umur`,
            `Value`,`adddih`,`useradd`,Status)
VALUES ('$NoDIH','$Tgl_DIH','$KodeApotik','$KodePelanggan','$KodePenagih','$Kodesls','$NoOrder','$Tgl_Order','$Umur',
        '$Value','$tglbuat','$username','OpenDIH');";
    mysql_query($input) or die(mysql_error());
    echo "<label id='info'><b>Data sukses disimpan</b></label>";
}
//echo "<br/>".$input."<br/>";
include "tampil_data.php";

?>