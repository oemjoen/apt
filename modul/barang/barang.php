<script type="text/javascript" src="modul/barang/ajax.js"></script>
<script language="javascript">	
	function editRow(ID){
	   var kode = ID; 
	   	$.ajax({
			type	: "POST",
			url		: "modul/barang/cari.php",
			data	: "kode="+kode,
			dataType: "json",
			success	: function(data){
				$("#kodeproduk").val(kode);
				$("#nama_barang").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#text_isi_satuan").val(data.text_isi_satuan);
				$("#text_berat_satuan").val(data.text_berat_satuan);
				$("#text_prinsipal").val(data.text_prinsipal);
				$("#text_supplier").val(data.text_supplier);
				$("#text_kat_khusus").val(data.text_kat_khusus);
				$("#text_kandungan").val(data.text_kandungan);
				$("#text_sediaan").val(data.text_sediaan);
			}
		});

	}
</script>

<?php
include '../../inc/inc.koneksi.php'; 
?>

	  <input type="hidden" name="textcabang" id='textcabang' value = "<?php echo $cabangrr; ?>"/>
	  <input type="hidden" name="textusername" id='textusername' value = "<?php echo $userrr; ?>"/>
	  
<table id='theList' width='100%'>
	<tr>
		<td>Kode Barang</td>
		<td>:</td>
		<td><input type='text' name='kodeproduk' id='kodeproduk'  size='10' lenght='10'></td>
	</tr>
	<tr>
		<td>Nama Barang</td>
		<td>:</td>
		<td><input type='text' name='nama_barang' id='nama_barang'  size='50' lenght='50'></td>
	</tr>
	<tr>
		<td>Satuan</td>
		<td>:</td>
		<td><select name='satuan' id='satuan'>
		<option value='' selected>-Pilih-</option>
        <?php		
		$sql	= "SELECT DISTINCT satuan FROM `mstproduk` ORDER BY satuan";
		$query	= mysql_query($sql);
		while($r=mysql_fetch_array($query)){
			echo "<option value='$r[satuan]'>$r[satuan]</option>";
		}?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Isi Satuan</td>
		<td>:</td>
		<td><input type='text' name='text_isi_satuan' id='text_isi_satuan'  size='20' lenght='20'></td>
	</tr>
	<tr>
		<td>Berat satuan</td>
		<td>:</td>
		<td><input type='text' name='text_berat_satuan' id='text_berat_satuan'  size='20' lenght='20'></td>
	</tr>	
	<tr>
		<td>Prinsipal</td>
		<td>:</td>
		<td><select name='text_prinsipal' id='text_prinsipal'>
		<option value='' selected>-Pilih-</option>
        <?php		
		$sql	= "SELECT * FROM `mstprinsipal` ORDER BY `namaprinsipal`";
		$query	= mysql_query($sql);
		while($r=mysql_fetch_array($query)){
			echo "<option value='$r[kodeprinsipal]'>$r[namaprinsipal]</option>";
		}?>
		</select>
	</tr>
	<tr>
		<td>Supplier</td>
		<td>:</td>
		<td><select name='text_supplier' id='text_supplier'>
		<option value='' selected>-Pilih-</option>
        <?php		
		$sql	= "SELECT * FROM `mstsupplier2` ORDER BY `kodesupplier`";
		$query	= mysql_query($sql);
		while($r=mysql_fetch_array($query)){
			echo "<option value='$r[kodesupplier]'>$r[namasupplier] - $r[kodesupplier]</option>";
		}?>
		</select>
	</tr>
	<tr>
		<td>Kategori Khusus</td>
		<td>:</td>
		<td><select name='text_kat_khusus' id='text_kat_khusus'>
		<option value='' selected>-Pilih-</option>
        <?php		
		$sql	= "SELECT * FROM mstkategorikhusus ORDER BY `namakatkhusus`;";
		$query	= mysql_query($sql);
		while($r=mysql_fetch_array($query)){
			echo "<option value='$r[kodekatkhusus]'>$r[namakatkhusus]</option>";
		}?>
		</select>
	</tr>
	<tr>
		<td>Kandungan</td>
		<td>:</td>
		<td><input type='text' name='text_kandungan' id='text_kandungan'  size='20' lenght='20'></td>
	</tr>	
	<tr>
		<td>Sediaan</td>
		<td>:</td>
		<td><input type='text' name='text_sediaan' id='text_sediaan'  size='20' lenght='20'></td>
	</tr>	
	
	
	
	<tr>
		<td colspan='3' align='center'>
		<button name='tambah' id='tambah'>Tambah</button>
		<button name='simpan' id='simpan'>Simpan</button>
		<button name='hapus' id='hapus'>Hapus</button>
		<button name='keluar' id='keluar'>Keluar</button>
		<button name='prodbaru' id='prodbaru'>Produk Baru</button>
		</td>
	</tr>
	</table>
	<div id='info' align='cener'></div>"
