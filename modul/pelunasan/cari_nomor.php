<?php
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_hdt.php";
include "../../inc/fungsi_tanggal.php";

$kode	= $_POST['kode'];
$cabang1 = $_POST['cabang1'];
$tgl = $_POST['tgl'];
$noerdit = $_POST['noerdit'];
$kap = $_POST['kap'];

date_default_timezone_set('Asia/Jakarta'); 
$countercek = date(m).date(Y);

//$text	= "SELECT max(kode_beli) as no_akhir FROM pembelian where cabang='$cabang1'";
//$text	= "SELECT MAX(RIGHT(NoDIH,5)) AS no_akhir FROM t_dih WHERE cabang='$cabang1' AND KodeApotik='$kap'";
$text	= "SELECT MAX(RIGHT(NoDIH,5)) AS no_akhir FROM t_dih WHERE KodeApotik='$kap'";
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);


if (empty($noerdit)){
		//if ($row>0){
			$data=mysql_fetch_array($sql);	
				//format kode beli BL0001
				//format kode beli SP/CAB/001/TGL/BLN/THN
				$no = $data['no_akhir'];
				$no_akhir = (int)$no;
			
				
				$no_akhir++;
				//membuat format kode beli
				//$kode_beli = 'MO/'.$cabang1.'/'.sprintf("%03s",$no_akhir).'/'.date(d).'/'.date(m).'/'.date(Y);
				
				//$data['nomor']	= $text;

				$data['nomor']	= 'DIH/'.$kap.'/'.sprintf("%05s",$no_akhir);
				$data['tglpredit']	= date(d)."-".date(m)."-".date(Y);
				
				echo json_encode($data);
		// }else{
			// $data['nomor']	= 'MO/'.$cabang1.'/001/'.date(d).'/'.date(m).'/'.date(Y);;

			// echo json_encode($data);
			
		// }
	}else {
				$data['nomor']	= $noerdit;
				$data['supp']  = combo_supplier_pr_edit($noerdit);
				$data['tglpredit']  = jin_date_sql(tanggal_pr($noerdit));
				echo json_encode($data);
	}
?>