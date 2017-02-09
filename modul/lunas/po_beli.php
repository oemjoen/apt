<script type="text/javascript" src="modul/lunas/ajax.js"></script>
<script language="javascript">	
$(document).ready(function() {
	$("#refresh").click(function() {
		window.location.reload();
		//alert('tes');
	});

});
	function editRow(ID){
	   var kode = ID; 
	   	$.ajax({
			type	: "POST",
			url		: "modul/lunas/cari.php",
			data	: "kode="+kode,
			dataType: "json",
			success	: function(data){
				$("#kode_barang").val(kode);
				$("#nama_barang").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#harga_beli").val(data.harga_beli);
				$("#harga_jual").val(data.harga_jual);
				$("#stok_awal").val(data.stok_awal);
			}
		});

	}

	function buat_kode() {
		var	kode	= $("#txt_kode").val();
		var tgl		= $("#txt_tgl_beli").val();
		var prins	= $("#cbo_prinsipal").val();
		var cabang1 = $("#textcabang").val();
		$.ajax({
			type	: "POST",
			url		: "modul/lunas/buat_nomor.php",
			data	: "kode="+kode+"&tgl="+tgl+"&cabang1="+cabang1+"&prins="+prins,
			dataType: "json",
			success	: function(data){
				$("#txt_kode").val(data.kode_pobeli);
				//alert(data.kode_pobeli);
			}
		});		
	}
</script>
	<h2 align="center">PELUNASAN</h2>
	<p align="right">
	  <input type="hidden" name="textcabang" id='textcabang' value = "<?php echo $cabangrr; ?>"/>
	  <input type="hidden" name="kodeedit" id='kodeedit' value = "<?php echo $_GET['no']; ?>"/>
	  <input type="hidden" name="kode_user" id='kode_user' value = "<?php echo $userrr; ?>"/>
      	  <input type="hidden" name="textKodeAP" id='textKodeAP' value = "<?php echo $userrr;?>" readonly/>
	  <input type="hidden" name="textNamaAP" id='textNamaAP' value = "<?php echo $namarr;?>" readonly/>
      <input type="hidden" name="textime" id='textime' value = "<?php echo date("Y-m-d H:i:s");?>" readonly/>
	  
    <?php echo $namarr;?> - cabang <?php echo $cabangrr; ?></p>

	<table id='theList' width='100%'>
<!--	<tr>
		<td width='15%'>Kode PO</td>
		<td width='2%'>:</td>
		<td><input type='text' name='txt_kode' id='txt_kode'  size='50'  readonly></td>
	</tr>-->
	<tr>
		<td width='15%'>Tanggal</td>
		<td width='2%'>:</td>
		<td><input type='text' name='txt_tgl_beli' id='txt_tgl_beli'  value = '<?php echo date("d-m-Y");?>' size='10' lenght='10' readonly></td>
	</tr>
	<tr>
		<td>No DIH</td>
		<td>:</td>
		<td><select name='cbo_kode' id='cbo_beli'>
		<option value=''>-Pilih DIH-</option>
		<?php		
		$sql	= "SELECT DISTINCT NoDIH FROM t_dih WHERE kodeApotik='$userrr' AND STATUS ='OpenDIH'";
		$query	= mysql_query($sql);
		while($r=mysql_fetch_array($query)){
			echo "<option value='$r[NoDIH]'>$r[NoDIH]</option>";
		}?>
		</select></td>
	</tr>
<!--<tr>
		<td>Pilih Prinsipal</td>
		<td>:</td>
	<td><select name='cbo_prinsipal' id='cbo_prinsipal' class='input' onchange="buat_kode()">
			<option value='' selected>-Pilih-</option>
			<?php		
		$sql	= "SELECT * FROM mstprinsipal order by namaprinsipal";
		$query	= mysql_query($sql);
		while($r=mysql_fetch_array($query)){
			echo "<option value='$r[kodeprinsipal]'>$r[namaprinsipal]</option>";
		}?>
		  </select>
	</td>
</tr>
-->
	<tr>
		<td colspan='3' align='center'>
		<button name='tambah' id='cari'>Cari</button>
		<button name='keluar' id='keluar'>Keluar</button>
		<!--<button name='cetak2' id='cetak2' >Cetak</button>-->
		<!-- <button type='' name='cetakrel' id='cetakrel' >Cetak Relokasi</button> -->
		<button name='refresh' id='refresh'>TAMBAH PELUNASAN</button>
		</td>
	</tr>
	</table>
	<div id='ket' align='center'></div>	
	<div id='info' align='center'></div>

