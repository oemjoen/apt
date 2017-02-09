<script type="text/javascript">
    $(function() {
        $("#theList tr:even").addClass("stripe1");
        $("#theList tr:odd").addClass("stripe2");

        $("#theList tr").hover(
            function() {
                $(this).toggleClass("highlight");
            },
            function() {
                $(this).toggleClass("highlight");
            }
        );
    });
</script>

<?php
include '../../inc/inc.koneksi.php';
include '../../inc/fungsi_hdt.php';
include '../../inc/fungsi_tanggal.php';
include '../../inc/fungsi_rupiah.php';
date_default_timezone_set('Asia/Jakarta'); 
//Tanggal
$kode1	= jin_date_sql($_GET['kode1']);
//Produk
$kode2	= $_GET['kode2'];
//cabang
$cabang	= $_GET['cabang'];

//cek Tgl
$hari_ini = date("Y-m-d");
$tglD = date('Y-m-t', strtotime($kode1));
// Tanggal pertama pada bulan ini
$tgl_awal = date('Y-m-01', strtotime($kode1));
// Tanggal terakhir pada bulan ini
$tgl_akhir = date('Y-m-t', strtotime($kode1));
//ambil bulan saja
$mth = date('m', strtotime($kode1));
$mth1 = date('m', strtotime($kode1.'+ 1 months'));
$yr = date('Y', strtotime($kode1));
$yr1 = date('Y', strtotime($kode1));

	$sqlProd = mysql_query("SELECT `Kode Produk` AS kodep, `Produk` AS nama,`Satuan` FROM `mproduk` WHERE `Kode Produk`='$kode2'");
	$hasilProd=mysql_fetch_array($sqlProd); 
	echo $_SERVER['REMOTE_ADDR'];
	echo gethostbyaddr($_SERVER['REMOTE_ADDR']);
	echo 
		"<p align='left'><font size='3'><b>ORDER VIA SMS <br>
	 	Periode : ".$hari_ini."<br></b></font></p>
<div id='info'>
	<table id='theList' width='100%'>
		<tr>
			<th >NO</th>
			<th >ORDER</th>
			<th >CABANG</th>
			<th >PELANGGAN</th>
			<th >NO TELP</th>
			<th >CONTENT</th>
			<th >TIME</th>
			<th >STATUS</th>
		</tr>
		";
	$sql1	= "SELECT DISTINCT Cabang,`No Order` AS NoOrder, `Kode Pelanggan` AS KPel,
				`Nama Pelanggan` AS NPel, Telp, Tanggal, Status
				FROM morder ORDER BY `No Order` DESC";	

	//	echo "<br>".$sql1."<br>";
	//die();
//		$dat = "";
		$no=0 ;
		$query = mysql_query($sql1);	
		while($r_data=mysql_fetch_array($query)){
		$no++;
		
		$sqlD = "SELECT Cabang,`No Order` AS NoOrder, `Kode Pelanggan` AS KPel, `Nama Pelanggan` AS NPel, 
					Telp, `Kode Produk` AS kProd, `Nama Produk` AS nProd,
					`Qty Produk` AS qtyProd, Status
					FROM morder WHERE `No Order`='$r_data[NoOrder]'";
		$queryD = mysql_query($sqlD);
		$detData = "";
			while($d_data=mysql_fetch_array($queryD)){
				$prod = mysql_query("select produk,`kode produk` as kode, satuan from mproduk 
										where `Kode Produk`='$d_data[kProd]'");
				while($pD = mysql_fetch_array($prod))
				$detData = $detData.$d_data[kProd]." - ".$d_data[nProd]." Sebanyak : ".$d_data[qtyProd]." ".$pD[satuan]."<br>";
			}
		$pelang = $r_data[KPel]." - ".$r_data[NPel];
		echo"	<tr>
					<td align='center'>$no</td>
					<td align='left'>$r_data[NoOrder]</td>
					<td align='left'>$r_data[Cabang]</td>
					<td align='left'>$pelang</td>
					<td align='left'>$r_data[Telp]</td>
					<td align='left'>$detData</td>
					<td align='left'>$r_data[Tanggal]</td>
					<td align='left'>$r_data[Status]</td>
				</tr>";
		
		}
	
		
		echo "</table></div>";
	
?>
