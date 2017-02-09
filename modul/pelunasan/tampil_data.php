<script type="text/javascript">
$(document).ready(function() {
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
});
</script>
<?php
include '../../inc/inc.koneksi.php';
//include '../../inc/fungsi_hdt.php';
$kode	= $_POST[kode];
//$kode	= 'BL0030';

echo "<table id='theList' width='100%'>
		<tr>
			<th>No.</th>
			<th>No Order</th>
			<th>Tanggal</th>
			<th>Penagih</th>
			<th>Kode Pelanggan</th>
			<th>Nama Pelanggan</th>
			<th>Salesman</th>
			<th>Total</th>
			<th>Saldo</th>
			<th>Edit</th>			
			<th>Hapus</th>
		</tr>";
	
		$sql = "SELECT *,b.`Nama Faktur` AS namapel FROM t_dih a, mretail b
                        WHERE a.`NoDIH`='$kode' AND a.`KodePelanggan`=b.`Kode`;
					";

		//echo $sql;
		$query = mysql_query($sql);
		
		$no=1;
		while($r_data=mysql_fetch_array($query)){
			$kodeproduk = $r_data[KodeProduk];
			$total	= $r_data[jumlah_beli];
			$kodeID = $kode.$r_data[KodeProduk];
			echo "<tr>
					<td align='center'>$no</td>
					<td>$r_data[NoDIH]</td>
					<td>$r_data[NoOrder]</td>
					<td>$r_data[KodePenagih]</td>
					<td>$r_data[KodePelanggan]</td>
					<td>$r_data[namapel]</td>
					<td>$r_data[KodeSalesman]</td>
					<td align='center'>".number_format($r_data[Value])."</td>
					<td align='center'>".number_format($r_data[Saldo])."</td>
					<td align='center'>
					<a href='javascript:editRow(\"{$kodeproduk}\")' ><img src='icon/thumb_up.png' border='0' id='edit' title='Edit' width='12' height='12' ></a>
					</td>
					<td align='center'>
					<a href='javascript:void(0)' onClick=\"hapus_data('$kodeID')\">
					<img src='icon/thumb_down.png' border='0' id='hapus' title='Hapus' width='12' height='12' >
					</a>
					</td>
					</tr>";
			$no++;
			$g_total = $g_total + $r_data[Qty] + $r_data[Bonus];
			$g_totalharga = $g_totalharga + $r_data[Total];			
		}
	echo "</table>";
//	echo "<table width='100%'>
//		<tr>
//			<td align='right'><h4><b>Total Qty Order : ".number_format($g_total);
//			echo "</br>Total Jumlah Order : Rp ".number_format($g_totalharga);
//	echo "</b></h4></td>
//		</tr>
//		</table>";
//?>