<?php
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_hdt.php";

$kode	= $_POST['kode'];
$cabang	= $_POST['cabang'];
$kodepr	= $_POST['kodepr'];
					
$text = "SELECT a.`KodeApotik`,b.`Nama Faktur` AS nmapt,a.`KodePelanggan`,c.`Nama Faktur` AS namapel,a.`NoOrder`,a.`TglOrder`,
                                SUM(a.`Total`) AS saldo,a.Salesman AS sls
                                FROM t_order a, mpelanggan b, mretail c
                                WHERE a.`KodeApotik`=b.`Kode` AND a.`KodePelanggan`=c.`Kode` AND a.`Status`='ProsesSP'
                                AND a.NoOrder='$kode'";
//echo $text.'<br>';
$sql 	= mysql_query($text) or die(mysql_error());
$row	= mysql_num_rows($sql);
//echo $text;
$produksyrat = produk_black_list($kode);
$produkoustandingbtb = cari_produk_btb_outstanding($cabang,$kode);
$produkoustandingpr = cari_produk_pr_outstanding($cabang,$kode,$kodepr);
$produkoustandingpr_pr = cari_produk_pr_outstanding_adapr($cabang,$kode,$kodepr);
$produkoustandingpr_nopr = cari_produk_pr_outstanding_nopr($cabang,$kode,$kodepr);
$produkoustandingpr_nopo = cari_produk_pr_outstanding_adapo($cabang,$kode,$kodepr);
$produkharga = number_format(produk_harga($kode));
$produktidaksp = produk_sp($cabang,$kode);
//echo $produksyrat;
//echo $cabang;

if ($row>0){
	while ($r=mysql_fetch_array($sql)){	

		$data['KodeApotik']		     	= $r[KodeApotik];
		$data['TglOrder']		       	= $r[TglOrder];
		$data['KodePelanggan']	       	= $r[KodePelanggan];
		$data['namapel']		    	= $r[namapel];
		$data['total']			     	= number_format($r[saldo]);
		$data['saldo']			    	= number_format($r[saldo]);
		$data['total1']			     	= ($r[saldo]);
		$data['saldo1']			    	= ($r[saldo]);
		$data['sls']			    	= ($r[sls]);
		echo json_encode($data);
	}
}else{

		
		$data['KodeApotik']		     	= '';
		$data['TglOrder']		       	= '';
		$data['KodePelanggan']	       	= '';
		$data['namapel']		    	= '';
		$data['total']			     	= '';
		$data['saldo']			    	= '';
		echo json_encode($data);

			
}
?>