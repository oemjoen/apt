<script type="text/javascript" src="modul/pelunasan/ajax.js"></script>
<script type="text/javascript">	
	
	//$("#data").load('modul/pelunasan/cari_nomor.php?kode='+$("#txt_kode_beli").val());
	
	
	
//fungsi jumlah	
	function hitung() {
      var qty = document.getElementById('txt_jumlah').value;
      var harga = document.getElementById('txt_hargajual').value;
      var bns = document.getElementById('txt_bonus').value;
      var disc1 = document.getElementById('txt_diskon').value;
	  if(qty=="")
	  {
		  qty = 0;
	  }
	  if(harga=="")
	  {
		  harga = 0;
	  }
	  if(bns=="")
	  {
		  bns = 0;
	  }
	  if(disc1=="")
	  {
		  disc1 = 0;
	  }
	  var disc = parseFloat(disc1).toFixed(2);
      var gross = (parseInt(qty) + parseInt(bns)) * parseInt(harga);
      var pot = (parseInt(bns) * parseInt(harga))+(parseInt(qty) * parseInt(harga) * (disc/100));
      var val = gross-pot;
      var ppn = val * 0.1;
      var tot = val + ppn;
      if (!isNaN(gross)) {
         document.getElementById('txt_gross').value = gross;
         document.getElementById('txt_potongan').value = pot;
         document.getElementById('txt_value').value = val;
		 document.getElementById('txt_ppn').value = ppn;
		 document.getElementById('txt_total').value = tot;
      }
}	
	function editRow(ID){
	   var kode = ID; 
	   	$.ajax({
			type	: "POST",
			url	: "modul/pelunasan/cari.php",
			data	: "kode="+kode,
			dataType: "json",
			success	: function(data){
				$("#txt_kode_barang").val(kode);
				$("#txt_kode_barang").focus();
			}
		});

	}

	
	function hapus_data(ID) {
		var kode = $("#txt_kode_beli").val(); 
		var id	= ID;
	   var pilih = confirm('Data yang akan dihapus kode = '+id+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url	: "modul/pelunasan/hapus.php",
				data	: "kode="+kode+"&id="+id,
				success	: function(data){
					$("#info").html(data);
					kosong();
				}
			});
		}
	}
	
	function tampil_data_retail() {
		var	koder	= $("#txt_kode").val();
		var cabang1 = $("#textcabang").val();
		$.ajax({
			type	: "POST",
			url		: "modul/pelunasan/tampil_limit.php",
			data	: "kode="+kode+"&cabang1="+cabang1,
			dataType: "json",
			success	: function(data){
				$("#info2").val(data);
				//alert(data.kode_pobeli);
			}
		});		
	}
</script>
<style type="text/css">
.readonly{
	background-color:#00FFFF;
}
.detail_readonly{
	background-color:#00FFFF;
}
h3 {
	font-family:Verdana, Geneva, sans-serif;
	font-size:16px;
	text-align:center;
	color:#009;
}
.bg_input {
	background-color:#CCCCCC;
}
</style>
<?php

include 'inc/inc.koneksi.php';

?>

	<h3>Buat DIH</h3>
	<p align="right">
	  <input type="hidden" name="textcabang" id='textcabang' value = "<?php echo $cabangrr;?>" readonly/>
	  <input type="hidden" name="kodeedit" id='kodeedit' value = "<?php echo $_GET['no'];?>" readonly/>
	  <input type="hidden" name="textusername" id='textusername' value = "<?php echo $userrr;?>" readonly/>
	  <input type="hidden" name="textKodeAP" id='textKodeAP' value = "<?php echo $userrr;?>" readonly/>
	  <input type="hidden" name="textNamaAP" id='textNamaAP' value = "<?php echo $namarr;?>" readonly/>
	  <input type="hidden" name="textime" id='textime' value = "<?php echo date("Y-m-d H:i:s");?>" readonly/>
    <?php echo $namarr;?> - cabang <?php echo $cabangrr;?></p><?php

echo "<p align=right>Login : $hari_ini, ";
echo tgl_indo(date("Y m d"));
echo " | ";
echo date("H:i:s");
echo " WIB</p>";

?>
	<table id='theList' width='100%'>
      <tr>
        <td>Kode DIH</td>
        <td>:</td>
        <td><input type='text' name='txt_kode_beli' id='txt_kode_beli'  size='50' lenght='50' class='input' readonly/></td>
      </tr>
      <tr>
        <td>Tanggal DIH</td>
        <td>:</td>
        <td><input type='text' name='txt_tgl_beli' id='txt_tgl_beli'  size='12' lenght='12' class='input' value=<?php

print (date('Y-m-d'));

?> readonly/></td>
      </tr>
<!--	  <tr>
		<td>Tipe</td>
		<td>:</td>
		<td><label><input type="checkbox" id="cbox1" value="Langsung">Langsung</label></td>
	  </tr>-->
      <tr>
        <td>Penagih</td>
        <td>:</td>
        <td><select name='cbo_retail' id='cbo_retail' class='input' onchange= 'tampil_data_retail()'>
            <option value='' selected>-Pilih-</option>
            <?php

$sql = "SELECT DISTINCT * FROM mkaryawan WHERE Menagih='Ya' AND STATUS='Aktif' AND cabang='$cabangrr' Order By Jabatan,Kode";
$query = mysql_query($sql);
while ($r = mysql_fetch_array($query))
{
    echo "<option value='$r[Kode]'>$r[Nama] - $r[Kode] - $r[Jabatan]</option>";
}

?>
          </select>
        </td>
      </tr>

    </table>
	<div class='bg_input'>
	<table width='100%' border="1">
	<tr>
		<th width="10%">No Order</th>
		<th width="5%">Tgl Order</th>
		<th width="10%">Kode Pelangan</th>
		<th width="20%">Nama Pelanggan</th>
		<th width="10%">Kode Salesman</th>
		<th width="3%">Total</th>
		<th width="5%">Saldo</th>
	</tr>
	<tr>
		
		<td><div align="center">
            <input type='text' name='txt_kode_barang' id='txt_kode_barang'  size='35' class='input_detail'></div></td>
	    <td><div align="center">
	      <input type='text' name='txt_tgl' id='txt_tgl'  size='15' align='center'  class='detail_readonly' readonly />
	    </div></td>
	    <td><div align="center">
	      <input type='text' name='txt_kodepel' id='txt_kodepel'  size='15' align='center'  class='detail_readonly' readonly />
	    </div></td>		
	    <td><div align="center">
	      <input type='text' name='txt_namapel' id='txt_namapel'  size='50' align='center'  class='detail_readonly' readonly />
	    </div></td>		
	    <td><div align="center">
	      <input type='text' name='txt_kode_sls' id='txt_kode_sls'  size='15' align='center'  class='detail_readonly' readonly />
	    </div></td>		
	    <td><div align="center">
	      <input type='text' name='txt_total' id='txt_total'  size='15' align='center'  class='detail_readonly' readonly />
	      <input type='hidden' name='txt_total1' id='txt_total1'  size='15' align='center'  class='detail_readonly' readonly />
	    </div></td>		
	    <td><div align="center">
	      <input type='text' name='txt_saldo' id='txt_saldo'  size='15' align='center'  class='detail_readonly' readonly />
	      <input type='hidden' name='txt_saldo1' id='txt_saldo1'  size='15' align='center'  class='detail_readonly' readonly />
	    </div></td>		
	</tr>	
	<tr>
		<td colspan='12' align='center'>
		<button name='tambah_detail' id='tambah_detail'>Tambah Faktur</button>
		<button name='simpan' id='simpan'>Simpan Faktur</button>	
		<button name='cetak2' id='cetak2'>Cetak</button>
		</td>
	</tr>
	</table>
	</div>
	<div id='info' align='center'></div>
	<div id='tombol'>
	<table width='100%'>
	<tr>
		<td align='center'>
		<button name='tambah_beli' id='tambah_beli'>Tambah DIH</button>
		<button name='keluar' id='keluar'>Keluar</button>
		</td>
	</tr>
	</table></div>


