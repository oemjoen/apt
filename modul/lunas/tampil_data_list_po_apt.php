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
	function editRow(ID){
	   var kode = ID; 
		window.location.href='media.php?module=edit_po_beli&no='+kode;

	}
	
	function cetakRow(ID){
	   var kode = ID; 
		window.location.href='modul/laporan/cetak_po.php?kode='+kode;

	}	
	function cetakRow1(ID){
	   var kode = ID; 
		window.location.href='modul/laporan/cetak_po_relokasi.php?kode='+kode;

	}	
	function cetakRow2(ID){
	   var kode = ID; 
		window.location.href='modul/laporan/cetak_po_relokasi2.php?kode='+kode;

	}
	function cetakRow3(ID){
	   var kode = ID; 
		window.location.href='modul/laporan/cetak_po_relokasi3.php?kode='+kode;

	}


	function lihatRow(ID){
	   	var kode = ID; 
		var cabang	= $("#textcabang").val();
		
	   	$.ajax({
			type	: "GET",
			url		: "modul/lunas/tampil_data_list_po.php",
			data	: "kode="+kode+"&cabang="+cabang,
			success	: function(data){
				$("#data").html(data);
			}
		});		
	}

	function AppAptRow(ID){
	   	var kode = ID; 
		var cabang	= $("#textcabang").val();
		var namauser	= $("#textnamauser").val();
		
	   	$.ajax({
			type	: "GET",
			url		: "modul/lunas/tampil_data_list_aproval_apt.php",
			data	: "kode="+kode+"&namauser="+namauser+"&cabang="+cabang,
			success	: function(data){
				$("#data").html(data);
			}
		});		
	}
</script>
<?php
include '../../inc/inc.koneksi.php';
include '../../inc/fungsi_hdt.php';
include "../../inc/fungsi_tanggal.php";
date_default_timezone_set('Asia/Jakarta');
 
$kode1	= $_GET['kode'];
$kode2	= $_GET['kode'];
$kode	= $_GET['kode'];
$cabang	= $_GET['cabang'];
$hal	= $_GET['hal'] ? $_GET['hal'] : 0;
$user	= $_GET['user'];
$lim	= 50;

$namauser = $_GET['namauser'];


$tableapp = "po_pembelian";
$fieldapp = "kodepo_beli";

if (stripos($kode, "PRE") !== false){ 
	$tableapp = "po_pembelian_pre";
	$fieldapp = "kodepo_beli";
}
if (stripos($kode, "PSI") !== false){ 
	$tableapp = "po_pembelian_psi";
	$fieldapp = "kodepo_beli";
}

$sqlapvapt = "update $tableapp set status_apv_apt='Y',user_apv_apt='$namauser',date_apv_apt=NOW() where $fieldapp='$kode'";
//echo $sqlapvapt; 

mysql_query($sqlapvapt);

if (empty($kode)){
	if ($cabang =='KPS')
	{
		$query2 = "SELECT DISTINCT a.`kodepo_beli`,a.`tglpo_beli`,a.`kode_beli`,a.`kode_prinsipal`,d.`namaprinsipal`,a.`kode_supplier`,b.`namasupplier` 
					FROM po_pembelian a
						LEFT JOIN mstsupplier2 b ON a.`kode_supplier`=b.`kodesupplier`
						LEFT JOIN `mstprinsipal` d ON a.`kode_prinsipal`=d.`kodeprinsipal` 
						ORDER BY a.`tglpo_beli` DESC,a.`cabang`,a.`kode_beli`";//echo "--1--".$query2;
	}
	else
	{
		$query2 = "SELECT DISTINCT a.`kodepo_beli`,a.`tglpo_beli`,a.`kode_beli`,a.`kode_prinsipal`,d.`namaprinsipal`,a.`kode_supplier`,b.`namasupplier` 
					FROM po_pembelian a
					LEFT JOIN mstsupplier2 b ON a.`kode_supplier`=b.`kodesupplier`
					LEFT JOIN `mstprinsipal` d ON a.`kode_prinsipal`=d.`kodeprinsipal` 
					WHERE a.cabang='$cabang'
					ORDER BY a.`tglpo_beli` DESC,a.`cabang`,a.`kode_beli`";//echo "--2--".$query2;
	}
}else{
	if ($cabang =='KPS')
	{
		$query2 = "SELECT * FROM po_pembelian WHERE kode_beli = '$kode'";//echo "--3--".$query2;
	}
	else
	{
		$query2 = "SELECT * FROM po_pembelian WHERE kode_beli = '$kode' AND cabang='$cabang'";//echo "--4--".$query2;
	}
}
	$data2	= mysql_query($query2);
	$jml	= mysql_num_rows($data2);
	
	$max	= ceil($jml/$lim);

if (empty($kode))
	{
		echo "<div id='info'>
		<table id='theList' width='100%'>
			<tr>
				<th>No.</th>
				<th>Kode PO</th>
				<th>Tanggal PO</th>
				<th>Kode Prinsipal</th>
				<th>Nama Prinsipal</th>
				<th>Kode Supplier</th>
				<th>Nama Supplier</th>
				<th>Kode PR</th>
				<th>Lihat</th>
<!--				<th>Edit</th>
-->				<th>CRutin</th>				
				<th>CRel1</th>				
				<th>CRel2</th>				
				<th>CRel3</th>				
				<th>Apt</th>				
			</tr>";		
	}else {
		echo "<div id='info'>
		<table id='theList' width='100%'>
			<tr>
				<th>No.</th>
				<th>Kode PO</th>
				<th>Qty</th>
				<th>Satuan</th>
				<th>Nama Barang</th>
				<th>Kode Barang</th>
				<th>Keterangan </th>
			</tr>";
	}


		if (empty($kode)){
			if ($cabang =='KPS'){
					$sql = "SELECT DISTINCT a.`kodepo_beli`,a.`tglpo_beli`,a.`kode_beli`,a.`kode_prinsipal`,d.`namaprinsipal`,a.`kode_supplier`,b.`namasupplier` ,status_apv_apt
							FROM po_pembelian a
								LEFT JOIN mstsupplier2 b ON a.`kode_supplier`=b.`kodesupplier`
								LEFT JOIN `mstprinsipal` d ON a.`kode_prinsipal`=d.`kodeprinsipal` 
								ORDER BY a.`tglpo_beli` DESC,a.`cabang`,a.`kode_beli` 
								LIMIT $hal,$lim";//echo "--5--".$sql;
							}
				else{
					$sql = "SELECT DISTINCT a.`kodepo_beli`,a.`tglpo_beli`,a.`kode_beli`,a.`kode_prinsipal`,d.`namaprinsipal`,a.`kode_supplier`,b.`namasupplier` ,status_apv_apt
							FROM po_pembelian a
								LEFT JOIN mstsupplier2 b ON a.`kode_supplier`=b.`kodesupplier`
								LEFT JOIN `mstprinsipal` d ON a.`kode_prinsipal`=d.`kodeprinsipal` 
								ORDER BY a.`tglpo_beli` DESC,a.`cabang`,a.`kode_beli` 
								WHERE a.cabang='$cabang'
								ORDER BY a.`tglpo_beli` DESC,a.`cabang`,a.`kode_beli`
								LIMIT $hal,$lim";//echo "--6--".$sql;
								}
			}	
		else
			{
				if ($cabang =='KPS'){
						$sql = "SELECT a.`kodepo_beli`,a.`tglpo_beli`,a.`kode_supplier`,b.`namasupplier`,a.`kode_barang`,c.`namaproduk`,c.`satuan`,
							a.`jumlah_beli_valid`,status_apv_apt
							FROM `po_pembelian` a 
							LEFT JOIN `mstsupplier2` b ON a.`kode_supplier`=b.`kodesupplier`
							LEFT JOIN `mstproduk` c ON a.`kode_barang`=c.`kodeproduk`
							WHERE a.kodepo_beli='$kode'
							ORDER BY a.kodepo_beli DESC, a.kode_barang ASC
							LIMIT $hal,$lim";//echo "--7--".$sql;
							}
					else {
						$sql = "SELECT a.`kodepo_beli`,a.`tglpo_beli`,a.`kode_supplier`,b.`namasupplier`,a.`kode_barang`,c.`namaproduk`,c.`satuan`,
							a.`jumlah_beli_valid`,status_apv_apt
							FROM `po_pembelian` a 
							LEFT JOIN `mstsupplier2` b ON a.`kode_supplier`=b.`kodesupplier`
							LEFT JOIN `mstproduk` c ON a.`kode_barang`=c.`kodeproduk`
							WHERE a.kodepo_beli='$kode' AND a.cabang='$cabang'
							ORDER BY a.kodepo_beli DESC, a.kode_barang ASC
							LIMIT $hal,$lim";				//echo "--8--".$sql;	
					}
			}
		
				
		//echo $sql;
		$query = mysql_query($sql);
		$no=1+$hal;
		if (empty($kode)){
		while($r_data=mysql_fetch_array($query)){
		$tanggaallll =  substr($r_data[tglpo_beli],0,4).substr($r_data[tglpo_beli],5,2);
		$rlokasisatu = cari_jml_relokasi($r_data[kodepo_beli]);
		$rlokasidua = cari_jml_relokasidua($r_data[kodepo_beli]);
		$rlokasitiga = cari_jml_relokasitiga($r_data[kodepo_beli]);
		
			echo "<tr>
					<td align='center'>$no</td>
					<td align='center'>$r_data[kodepo_beli]</td>
					<td align='center'>$r_data[tglpo_beli]</td>
					<td align='center'>$r_data[kode_prinsipal]</td>
					<td>$r_data[namaprinsipal]</td>
					<td>$r_data[kode_supplier]</td>
					<td>$r_data[namasupplier]</td>
					<td>$r_data[kode_beli]</td>
					<td align='center'><a href='javascript:lihatRow(\"{$r_data[kodepo_beli]}\")' ><img src='icon/magnifier.png' border='0' id='lihatttt' title='Lihat' width='12' height='12' ></a></td>
<!--					<td align='center'>";if (($tanggaallll)  >= date('Ym') ){echo "<a href='javascript:editRow(\"{$r_data[kodepo_beli]}\")' ><img src='icon/thumb_up.png' border='0' id='edit' title='Edit' width='12' height='12' ></a>";}echo "</td>
-->					<td align='center'><a href='javascript:cetakRow(\"{$r_data[kodepo_beli]}\")' ><img src='icon/printer.png' border='0' id='cetakkk' title='Cetak Rutin' width='12' height='12' ></a></td>
					<td align='center'>";if ($rlokasisatu > 0){ echo "<a href='javascript:cetakRow1(\"{$r_data[kodepo_beli]}\")' ><img src='icon/printer.png' border='0' id='cetakkk' title='Cetak Relokasi 1' width='12' height='12' ></a>";} echo "</td>
					<td align='center'>";if ($rlokasidua > 0){ echo "<a href='javascript:cetakRow2(\"{$r_data[kodepo_beli]}\")' ><img src='icon/printer.png' border='0' id='cetakkk' title='Cetak Relokasi 2' width='12' height='12' ></a>";} echo "</td>
					<td align='center'>";if ($rlokasitiga > 0){ echo "<a href='javascript:cetakRow3(\"{$r_data[kodepo_beli]}\")' ><img src='icon/printer.png' border='0' id='cetakkk' title='Cetak Relokasi 3' width='12' height='12' ></a>";} echo "</td>
					<td align='center'>";if (($r_data[status_apv_apt] == "N")){if($user ==  'NININGKPS'){echo "<a href='javascript:AppAptRow(\"{$r_data[kodepo_beli]}\")' ><img src='icon/key_go.png' border='0' id='cetakkk' title='Appoval Apt' width='12' height='12' ></a>";} echo '<strong> <font color="red"> NotApov </font></strong>';}else{echo '<strong> <font color="green"> Aprov </font></strong>';}echo "</td>";
					echo "</tr>";
			$no++;//echo "--9--";
		}
		}else {
		while($r_data=mysql_fetch_array($query)){		
			echo "<tr>
					<td align='center'>$no</td>
					<td align='center'>$r_data[kodepo_beli]</td>
					<td align='center'>$r_data[jumlah_beli_valid]</td>
					<td>$r_data[satuan]</td>
					<td>$r_data[namaproduk]</td>
					<td>$r_data[kode_barang]</td>
					<td>$r_data[ket_prinsipal]</td>
					</tr>";//echo "--10--";
			$no++;
		}
		}
	echo "</table>";
	echo "<table width='100%'>
		<tr>
			<td>Jumlah Data : $jml</td>";
		if (empty($kode)){
		echo "<td align='right'>Halaman :";
			for ($h = 1; $h <= $max; $h++) {
					$list[$h] = $lim * $h - $lim;
					echo " <a href='javascript:void(0)' ";?> 
                    onClick="$.get('modul/lunas/tampil_data_list_po.php?cabang=<?php echo $cabang;?>&user=<?php echo $_GET['user'];?>&hal=<?php echo $list[$h]; ?>', 
                    null, function(data) {$('#info').html(data);})" <?php echo">".$h."</a> ";
				}
	echo "</td>";
		}else{
		echo "<td align='right'>Halaman :";
			for ($h = 1; $h <= $max; $h++) {
					$list[$h] = $lim * $h - $lim;
					echo " <a href='javascript:void(0)' ";?> 
                    onClick="$.get('modul/lunas/tampil_data_list_po.php?cabang=<?php echo $cabang;?>&kode=<?php echo $_GET['kode'];?>&kode=<?php echo $_GET['kode'];?>&user=<?php echo $_GET['user'];?>&hal=<?php echo $list[$h]; ?>', 
                    null, function(data) {$('#info').html(data);})" <?php echo">".$h."</a> ";
				}
	echo "</td>";
		}
	echo "</tr>
		</table>";
	echo "</div>";
?>