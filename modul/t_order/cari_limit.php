<?php

include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_hdt.php";
include "../../inc/fungsi_rupiah.php";

$kode = $_POST['kode'];
$cabang = $_POST['cabang'];
$kodeOr = $_POST['kodeOr'];

$text = "SELECT a.`Kode`,a.`Nama Faktur` AS namafaktur,a.`Contact Person` AS kontak,
            	a.`Alamat`,a.`Contact Person` AS kontak,a.`Telp`,a.`smsP`,
            	IFNULL(a.`Limit Kredit`,0) AS limitk,
            	IFNULL(SUM(b.`Total`),0) AS piut, IFNULL((IFNULL(a.`Limit Kredit`,0) - IFNULL(SUM(b.`Total`),0)),0) AS sisa
            	FROM mretail a 
            LEFT JOIN t_order b ON a.`Kode`=b.`KodePelanggan`
            WHERE a.Cabang='$cabang' AND a.Kode='$kode'";

//echo $text.'<br>';
$sql = mysql_query($text) or die(mysql_error());
$row = mysql_num_rows($sql);
//echo $text;

if ($row > 0)
{
    while ($r = mysql_fetch_array($sql))
    {

        /**
         * $r[Kode].' - '.$r[namafaktur].'&#013;&#010;'.$r[Alamat].'&#013;&#010;Contact Person : '.
         * $r[kontak]."&#013;&#010;Telp : ".$r[Telp]." - SMS Order : ".$r[smsP]."&#013;&#010;Limit : ".
         * format_rupiah_koma($r[limitk])."&#013;&#010;Piutang : ".format_rupiah_koma($r[piut])."&#013;&#010;Saldo : ".
         * format_rupiah_koma($r[sisa])
         */
        $cek = $r[Kode] . ' - ' . $r[namafaktur] . '<br>' . $r[Alamat] .
            '<br>Contact Person : ' . $r[kontak] . "&#013;&#010;Telp : " . $r[Telp] .
            " - SMS Order : " . $r[smsP] . "&#013;&#010;Limit : " . format_rupiah_koma($r[limitk]) .
            "&#013;&#010;Piutang : " . format_rupiah_koma($r[piut]) . "&#013;&#010;Saldo : " .
            format_rupiah_koma($r[sisa]) . "<br>";
        $breaks = array(
            "<br />",
            "<br>",
            "<br/>",
            "&#013;&#010;");
        $textD = str_ireplace($breaks, "\r\n", $cek);
        $data['limit'] = $textD;
        $data['saldo'] = $r[sisa];

        echo json_encode($data);
    }
} else
{
    $data['limit'] = '';
    $data['saldo'] = 0;
    echo json_encode($data);
}

?>