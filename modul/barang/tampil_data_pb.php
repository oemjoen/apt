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
$hal	= $_GET['hal'] ? $_GET['hal'] : 0;
$lim	= 100;

	$query2	= "SELECT * FROM mstproduk WHERE `date_add` > (NOW() - INTERVAL '1' MONTH)";
	$data2	= mysql_query($query2);
	$jml	= mysql_num_rows($data2);
	
	$max	= ceil($jml/$lim);

echo "<table id='theList' width='100%'>
		<tr>
			<th>No.</th>
			<th>Nama Barang</th>
			<th>Kode Barang</th>
			<th>Satuan</th>
			<th>Kandungan</th>
			<th>Sediaan</th>
			<th>Isi Satuan</th>
			<th>Berat Satuan</br>(gram)</th>
			<th>Harga Jual</th>
			<th>Prinsipal</th>
			<th>Supplier</th>
			<th>Kategori Khusus</th>
			<th>Tanggal Buat</th>
			<th>Aksi</th>
		</tr>";
		$sql = "SELECT a.*,b.`namasupplier`,c.`namaprinsipal`,d.`namakatkhusus` FROM mstproduk a
					LEFT JOIN `mstsupplier2` b ON a.`kodesupplier`= b.`kodesupplier`
					LEFT JOIN `mstprinsipal` c ON a.`kodeprinsipal` = c.`kodeprinsipal`
					LEFT JOIN `mstkategorikhusus` d ON a.`kategorikhusus` = d.`kodekatkhusus`
				WHERE a.`date_add` > (NOW() - INTERVAL '1' MONTH)
					ORDER BY a.date_add DESC,b.namasupplier,a.namaproduk,c.`namaprinsipal`
				LIMIT $hal,$lim";
				
		//echo $sql;
		$query = mysql_query($sql);
		
		$no=1+$hal;
		while($r_data=mysql_fetch_array($query)){
			$kodeproduk = $r_data[kodeproduk];
			$hargabarang = number_format($r_data[hargajual]);
			echo "<tr>
						<td align='center'>$no</td>
						<td>$r_data[namaproduk]</td>
						<td>$r_data[kodeproduk]</td>
						<td>$r_data[satuan]</td>
						<td>$r_data[kandungan]</td>
						<td>$r_data[sediaan]</td>
						<td align='center'>$r_data[isisatuan]</td>
						<td align='center'>$r_data[beratsatuan]</td>
						<td align='right'>$hargabarang</td>
						<td>$r_data[namaprinsipal]</td>
						<td>$r_data[namasupplier]</td>
						<td>$r_data[namakatkhusus]</td>
						<td>$r_data[date_add]</td>
						<td align='center'>
							<a href='javascript:editRow(\"{$kodeproduk}\")' ><img src='icon/thumb_up.png' border='0' id='edit' title='Edit' width='12' height='12' ></a>
						</td>
					</tr>";
			$no++;
		}
		
	echo "</table>";
	echo "<table width='100%'>
		<tr>
			<td>Jumlah Data : $jml</td>
			<td align='right'>Halaman :";
			for ($h = 1; $h <= $max; $h++) {
					$list[$h] = $lim * $h - $lim;
					echo " <a href='javascript:void(0)' ";?> 
                    onClick="$.get('modul/barang/tampil_data_pb.php?hal=<?php echo $list[$h]; ?>', 
                    null, function(data) {$('#info').html(data);})" <?php echo">".$h."</a> ";
				}
	echo "</td>
		</tr>
		</table>";
?>