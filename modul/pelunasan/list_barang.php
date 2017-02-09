<?php

include "../../inc/inc.koneksi.php";

$q = $_GET["q"];
$cabang = $_GET["kd"];
$textKodeAP = $_GET["ap"];
if (!$q)
    return;

$sql = mysql_query("SELECT nomor FROM (                                
                    SELECT a.`KodeApotik`,b.`Nama Faktur` AS nmapt,a.`KodePelanggan`,c.`Nama Faktur` AS namapel,a.`NoOrder` AS nomor ,a.`TglOrder`,
                                                    SUM(a.`Total`) AS saldo, e.Nama
                                                    FROM t_order a, mpelanggan b, mretail c, mkaryawan e
                                                    WHERE a.`KodeApotik`=b.`Kode` AND a.`KodePelanggan`=c.`Kode` AND a.`Status`='ProsesSP'
                                                    AND a.Cabang='$cabang' AND a.`KodeApotik`='$textKodeAP'
                                                    AND (a.`NoOrder` LIKE '%$q%' OR c.`Nama Faktur` LIKE '%$q%') AND a.`KodePelanggan` IS NOT NULL
                                                    AND a.`Salesman`=e.Kode AND a.`Cabang`=e.Cabang
                                                    GROUP BY a.`NoOrder`)xx 
                                                    LEFT JOIN t_dih yy ON xx.nomor=yy.NoOrder                                
                                                    ;");

//                                                    AND Cabang='$cabang' AND a.`KodeApotik`='$textKodeAP'

while ($r = mysql_fetch_array($sql))
{
    $kode = $r['nomor'];
    //$nama = $r['nama_barang'];
    echo "$kode\n";
    //echo $kode;
}

?>