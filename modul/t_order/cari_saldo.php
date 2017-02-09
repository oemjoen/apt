<?php

include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_hdt.php";
include "../../inc/fungsi_rupiah.php";

$kodeOr = $_POST['kodeOr'];
$kodeProd = $_POST['kodeProd'];
$text = "SELECT IFNULL(SUM(Value + Ppn),0) AS tot FROM t_order WHERE NoOrder='$kodeOr' AND KodeProduk !='$kodeProd'
                GROUP BY NoOrder";

//echo $text.'<br>';
$sql = mysql_query($text) or die(mysql_error());
$row = mysql_num_rows($sql);
//echo $text;

if ($row > 0)
{
    while ($r = mysql_fetch_array($sql))
    {

        $data['tot'] = $r[tot];
        //		$data['tot']	     		= $text;
        echo json_encode($data);
    }
    
    
} else
{

    $data['tot'] = 0;
    echo json_encode($data);
}

?>